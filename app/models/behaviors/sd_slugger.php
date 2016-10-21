<?php
/* 
 * Down an dirty slugging hack for SD system
 */

class SdSluggerBehavior extends ModelBehavior
{

	function setup(&$Model, $settings = array())
	{
		$default = array('label' => array('name', 'postfix_field'), 'slug' => 'slug',
                            'separator' => '-',
                            'overwrite' => false );

		if (!isset($this->__settings[$Model->alias]))
		{
			$this->__settings[$Model->alias] = $default;
		}

		$this->__settings[$Model->alias] = am($this->__settings[$Model->alias], ife(is_array($settings), $settings, array()));
	}
    
    function beforeValidate(&$Model) {
        $return = parent::beforeValidate($Model);
        // create slug

        if ( empty($Model->data[$Model->alias]['slug']) ) {
            $slug = $Model->data[$Model->alias]['name'];

            if ( isset( $Model->data[$Model->alias]['postfix_field']) )
                $slug = $slug . '_'. $Model->data[$Model->alias]['postfix_field'];

            // create the slug
            $slug = Inflector::slug($slug);
            $slug = strtolower(str_replace('_', '-' , trim($slug)));
        }
        else {
            $slug = $Model->data[$Model->alias]['slug'];
        }
        
        // check if it's already in the table
        if ( isset($Model->data[$Model->alias]['id'])) {
            $id = $Model->data[$Model->alias]['id'];
            $Model->contain();
            $count = $Model->find('count', array('conditions' => array('id' => $id, 'slug LIKE' => "$slug%") ));
        } else {
            $Model->contain();
            $count = $Model->find('count', array('conditions' => array('slug LIKE' => "$slug%") ));
        }

        if ($count > 0)
            $slug = $slug . intval( $count + 1);


        $Model->data[$Model->alias]['slug'] = $slug;
        return true;
    }
}
?>

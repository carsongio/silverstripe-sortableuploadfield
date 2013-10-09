<?php

    class Sortable extends DataExtension {

        static $db = array(
            'Sort' => 'Int'
        );

        public function augmentSQL(SQLQuery &$query, DataQuery &$dataQuery = null) {
            if($order=$query->getOrderBy()){
                if(!array_key_exists("Sort", $order))
                    $query->addOrderBy($this->owner->ClassName.".Sort","ASC");
            }
        }

        /**
         * Thank you Uncle Cheese!
         */

        public function onBeforeWrite(){
            if(!$this->owner->ID) {
                $classes = ClassInfo::dataClassesFor($this->owner->ClassName);
                $sql = new SQLQuery('count(ID)', array_shift($classes));
                $val = $sql->execute()->value();
                $this->owner->Sort = is_numeric($val) ? $val+1 : 1;
            }
        }

    }
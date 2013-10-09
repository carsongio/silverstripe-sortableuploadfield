<?php

    class SortableUploadField extends UploadField{

        protected $templateFileButtons = 'SortableUploadFieldFileButtons';

        public function FieldHolder($properties = array()) {
            $obj = ($properties) ? $this->customise($properties) : $this;

            return $obj->renderWith("CustomFieldHolder");
        }

        public function __construct($name, $title = null, SS_List $items = null) {
            parent::__construct($name, $title = null, $items = null);
        }

        public function Field($properties = array()) {
            Requirements::javascript("sortableuploadfield/javascript/SortableUploadField.js");
            Requirements::css("sortableuploadfield/css/SortableUploadField.css");

            $fields = parent::Field($properties);

            return $fields;
        }

        public function getItemHandler($itemID) {
            return SortableUploadField_ItemHandler::create($this, $itemID);
        }

        protected function customiseFile(File $file) {
            $file = $file->customise(array(
                'UploadFieldHasRelation' => $this->managesRelation(),
                'UploadFieldThumbnailURL' => $this->getThumbnailURLForFile($file),
                'UploadFieldRemoveLink' => $this->getItemHandler($file->ID)->RemoveLink(),
                'UploadFieldDeleteLink' => $this->getItemHandler($file->ID)->DeleteLink(),
                'UploadFieldEditLink' => $this->getItemHandler($file->ID)->EditLink(),
                'UploadFieldSortLink' => $this->getItemHandler($file->ID)->SortLink()
            ));
            // we do this in a second customise to have the access to the previous customisations
            return $file->customise(array(
                'UploadFieldFileButtons' => $file->renderWith($this->getTemplateFileButtons())
            ));
        }

        public function getTest(){
            return 1;
        }
    }

class SortableUploadField_ItemHandler extends UploadField_ItemHandler {

    public static $allowed_actions = array(
        'sort' => true,
        'delete' => true,
        'edit' => true,
        'EditForm' => true
    );

    public function SortLink() {
        return $this->Link('sort');
    }

    public function sort(){
        $idlist = $this->request->postVar('list');
        $relationName = $this->parent->getName();
        $record = $this->parent->getRecord();
        $list = $record->$relationName();
        if(is_array($idlist)){
            $counter = 0;
            foreach($idlist as $id) {
                if(is_numeric($id)) {
                    ++$counter;
                    DB::query(sprintf("UPDATE \"%s\" SET \"Sort\" = %d WHERE \"ID\" = '%d'",
                        $list->dataClass, $counter, $id));
                }
            }
        }
    }

}

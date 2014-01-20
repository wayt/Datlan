<?php

namespace Application\Model;

class NewsMapper extends \Quokka\Database\AbstractMapper {

    public function createEntity($data) {

        $new = new News();
        $new->setId($data['new_id']);
        $new->setTitle($data['new_title']);
        $new->setContent($data['new_content']);
        $new->setDate($data['new_date']);
        $new->setBy($data['new_by']);

        return $new;
    }


    public function saveEntity($entity) {
    }


    public function fetchAllNews() {

        return $this->fetchAll('SELECT * FROM t_news ORDER BY new_date DESC');
    }
}

<?php

namespace Application\Model;

class TeamMapper extends \Quokka\Database\AbstractMapper {

    public function createEntity($data) {

        $team = new Team();
        $team->setId($data['tea_id']);
        $team->setName($data['tea_name']);
        $team->setTag($data['tea_tag']);
        $team->setPassword($data['tea_password']);

        return $team;
    }

    public function saveEntity($team) {

        $data = [
            'tea_name' => $team->getName(),
            'tea_tag' => $team->getTag(),
            'tea_password' => $team->getPassword(),
        ];

        if ($team->getId() == null) {

            $columns = implode(',', array_keys($data));
            $values = implode(',', array_fill(0, count($data), '?'));
            $this->execute('INSERT INTO t_team(tea_id, ' . $columns . ') VALUES(NULL, ' . $values . ');', array_values($data));
            $team->setId($this->getPDO()->lastInsertId());
        }
        else {

            $columns = implode('= ?,', array_keys($data));
            $data[] = $team->getId();
            $this->execute('UPDATE t_team SET ' . $columns . ' = ? WHERE use_id = ?;', array_values($data));
        }
    }

    public function fetchOneById($id) {

        return $this->fetchOne('SELECT * FROM t_team WHERE tea_id = ?', [$id]);
    }

    public function fetchOneByPassword($tag, $password) {

        return $this->fetchOne('SELECT * FROM t_team WHERE tea_tag = ? AND tea_password = ?', [$tag, $password]);
    }
}

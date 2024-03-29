<?php

namespace Application\Model;

class TeamMapper extends \Quokka\Database\AbstractMapper {

    public function createEntity($data) {

        $team = new Team();
        $team->setId($data['tea_id']);
        $team->setName($data['tea_name']);
        $team->setTag($data['tea_tag']);
        $team->setPassword($data['tea_password']);
        $team->setCreator($data['tea_creator']);

        return $team;
    }

    public function saveEntity($team) {

        $data = [
            'tea_name' => $team->getName(),
            'tea_tag' => $team->getTag(),
            'tea_password' => $team->getPassword(),
            'tea_creator' => $team->getCreator()
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

    public function fetchOneByTag($tag) {

        return $this->fetchOne('SELECT * FROM t_team WHERE tea_tag = ?', [$tag]);
    }

    public function fetchOneByName($name) {

        return $this->fetchOne('SELECT * FROM t_team WHERE tea_name = ?', [$name]);
    }

    public function removeById($id) {

        return $this->execute('DELETE FROM t_team WHERE tea_id = ?', [$id]);
    }

    public function countTeams() {

        $query = $this->getPDO()->prepare('SELECT COUNT(tea_id) FROM t_team');
        $query->execute();
        return $query->fetchColumn();    
    }

    public function fetchAllTeams() {
        return $this->fetchAll('SELECT * FROM t_team');
    }
}

<?php

namespace Application\Model;

class UserMapper extends \Quokka\Database\AbstractMapper implements \Quokka\Auth\InterfaceAuthenticator {

    public function createEntity($data) {

        $user = new User();
        $user->setId($data['use_id']);
        $user->setActive($data['use_active']);
        $user->setKey($data['use_key']);
        $user->setUsername($data['use_username']);
        $user->setGroup($data['use_group']);
        $user->setPassword($data['use_password']);
        $user->setEmail($data['use_email']);
        $user->setLastname($data['use_lastname']);
        $user->setFirstname($data['use_firstname']);
        $user->setAddress($data['use_address']);
        $user->setPostcode($data['use_postcode']);
        $user->setCity($data['use_city']);
        $user->setRegistered($data['use_registered']);

        return $user;
    }

    public function saveEntity($user) {

        $data = [
            'use_active' => $user->getActive(),
            'use_key' => $user->getKey(),
            'use_username' => $user->getUsername(),
            'use_group' => $user->getGroup(),
            'use_password' => $user->getPassword(),
            'use_email' => $user->getEmail(),
            'use_lastname' => $user->getLastname(),
            'use_firstname' => $user->getFirstname(),
            'use_address' => $user->getAddress(),
            'use_postcode' => $user->getPostcode(),
            'use_city' => $user->getCity(),
            'use_registered' => $user->getRegistered()
        ];

        if ($user->getId() == null) {

            $columns = implode(',', array_keys($data));
            $values = implode(',', array_fill(0, count($data), '?'));
            $this->execute('INSERT INTO t_user(use_id, ' . $columns . ') VALUES(NULL, ' . $values . ');', array_values($data));
            $user->setId($this->getPDO()->lastInsertId());
        }
        else {

            $columns = implode('= ?,', array_keys($data));
            $data[] = $user->getId();
            $this->execute('UPDATE t_user SET ' . $columns . ' = ? WHERE use_id = ?;', array_values($data));
        }
    }

    public function authenticate($identity, $credential) {

        $user = $this->fetchOne(
            'SELECT * FROM t_user WHERE use_username = ? AND use_password  = ? AND use_active = 1;',
            [
                $identity,
                sha1($credential)
            ]
        );

        return $user;
    }

    public function fetchOneByKey($key) {

        return $this->fetchOne('SELECT * FROM t_user WHERE use_key = ?', [$key]);
    }

    public function fetchOneByEmail($email) {

        return $this->fetchOne('SELECT * FROM t_user WHERE use_email = ?', [$email]);
    }

    public function fetchOneByUsername($username) {

        return $this->fetchOne('SELECT * FROM t_user WHERE use_username = ?', [$username]);
    }
}

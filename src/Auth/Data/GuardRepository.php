<?php

namespace Lychee\Auth\Data;

use Lychee\Support\Data\RepositoryInterface;
use Lychee\Support\Data\AttributeHydrator;
use Doctrine\DBAL\Connection;

class GuardRepository
{
    protected $db;
    protected $attributes = [
        'username',
        'password',
        'identifier'
    ];
    protected $table = 'lychee_settings';
    protected $tableAlias = 's';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function find()
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('*')
            ->from($this->table, $this->tableAlias)
            ->andWhere(
                $qb->expr()->in(
                    $this->tableAlias.'.key',
                    $qb->createNamedParameter($this->attributes, Connection::PARAM_STR_ARRAY)
                )
            );

        return (
            (new AttributeHydrator(
                $qb->execute()->fetchAll()
            ))->hydrate()
        );
    }

    public function save($entity): void
    {

    }

    public function saveCredential(string $username, string $password): array
    {
        $credential = [
            'username' => getHashedString($username),
            'password' => getHashedString($password)
        ];

        $success = [
            'username' => false,
            'password' => false
        ];
        
        $qb = $this->db->createQueryBuilder();
        $qb->update($this->table, $this->tableAlias);

        foreach ($credential as $key => $value) {
            $qb->set(
                $this->tableAlias . '.value',
                $qb->createNamedParameter($value, \PDO::PARAM_STR)
            )->where(
                $qb->expr()->eq(
                    $this->tableAlias . '.key',
                    $qb->createNamedParameter($key, \PDO::PARAM_STR)
                )
            );
            
            $success[$key] = ($qb->execute() > 0);
        }

        return $success;
    }
}

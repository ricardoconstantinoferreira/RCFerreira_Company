<?php

declare(strict_types=1);

namespace RCFerreira\Company\Api\Data;

interface CompanyInterface
{
    public const TABLE = 'rcferreira_company';
    public const ENTITY_ID = 'entity_id';
    public const CNPJ = 'cnpj';
    public const RAZAO_SOCIAL = 'razao_social';
    public const NOME_FANTASIA = 'nome_fantasia';
    public const EMAIL = 'email';
    public const MEI = 'mei';
    public const SIMPLES = 'simples';

    public const ADDRESS = 'address';

    /**
     * @param $entity_id
     * @return mixed
     */
    public function setId($entity_id);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $cnpj
     * @return CompanyInterface
     */
    public function setCnpj(string $cnpj): CompanyInterface;

    /**
     * @return string
     */
    public function getCnpj(): string;

    /**
     * @param string $razaoSocial
     * @return CompanyInterface
     */
    public function setRazaoSocial(string $razaoSocial): CompanyInterface;

    /**
     * @return string
     */
    public function getRazaoSocial(): string;

    /**
     * @param string $nomeFantasia
     * @return CompanyInterface
     */
    public function setNomeFantasia(string $nomeFantasia): CompanyInterface;

    /**
     * @return string
     */
    public function getNomeFantasia(): string;

    /**
     * @param string $email
     * @return CompanyInterface
     */
    public function setEmail(string $email): CompanyInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param bool $mei
     * @return CompanyInterface
     */
    public function setMei(bool $mei): CompanyInterface;

    /**
     * @return string
     */
    public function getMei(): bool;

    /**
     * @param bool $simples
     * @return CompanyInterface
     */
    public function setSimples(bool $simples): CompanyInterface;

    /**
     * @return string
     */
    public function getSimples(): bool;

    /**
     * @param string $address
     * @return CompanyInterface
     */
    public function setAddress(string $address): CompanyInterface;

    /**
     * @return string
     */
    public function getAddress(): string;
}

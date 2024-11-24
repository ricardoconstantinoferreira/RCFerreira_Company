<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model;

use RCFerreira\Company\Api\Data\CompanyInterface;
use Magento\Framework\Model\AbstractModel;
use RCFerreira\Company\Model\ResourceModel\Company as ResourceModelCompany;

class Company extends AbstractModel implements CompanyInterface
{

    public function _construct()
    {
        $this->_init(ResourceModelCompany::class);
    }

    /**
     * @param $entity_id
     * @return mixed|Company
     */
    public function setId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * @return array|mixed|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param string $cnpj
     * @return CompanyInterface
     */
    public function setCnpj(string $cnpj): CompanyInterface
    {
        return $this->setData(self::CNPJ, $cnpj);
    }

    /**
     * @return string
     */
    public function getCnpj(): string
    {
        return $this->getData(self::CNPJ);
    }

    /**
     * @param string $razaoSocial
     * @return CompanyInterface
     */
    public function setRazaoSocial(string $razaoSocial): CompanyInterface
    {
        return $this->setData(self::RAZAO_SOCIAL, $razaoSocial);
    }

    /**
     * @return string
     */
    public function getRazaoSocial(): string
    {
        return $this->getData(self::RAZAO_SOCIAL);
    }

    /**
     * @param string $nomeFantasia
     * @return CompanyInterface
     */
    public function setNomeFantasia(string $nomeFantasia): CompanyInterface
    {
        return $this->setData(self::NOME_FANTASIA, $nomeFantasia);
    }

    /**
     * @return string
     */
    public function getNomeFantasia(): string
    {
        return $this->getData(self::NOME_FANTASIA);
    }

    /**
     * @param string $email
     * @return CompanyInterface
     */
    public function setEmail(string $email): CompanyInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @param bool $mei
     * @return CompanyInterface
     */
    public function setMei(bool $mei): CompanyInterface
    {
        return $this->setData(self::MEI, $mei);
    }

    /**
     * @return strbooling
     */
    public function getMei(): bool
    {
        return (bool) $this->getData(self::MEI);
    }

    /**
     * @param bool $simples
     * @return CompanyInterface
     */
    public function setSimples(bool $simples): CompanyInterface
    {
        return $this->setData(self::SIMPLES, $simples);
    }

    /**
     * @return bool
     */
    public function getSimples(): bool
    {
        return (bool) $this->getData(self::SIMPLES);
    }
}

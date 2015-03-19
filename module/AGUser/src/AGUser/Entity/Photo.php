<?php

namespace AGUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="aguser_photo", indexes={@ORM\Index(name="fk_aguser_photo_aguser_users1_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="AGUser\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=false)
     */
    private $foto;

    /**
     * @var \AGUser\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AGUser\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function __construct(array $options = array()) 
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
    }    
    
    public function getId() {
        return $this->id;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'foto' => $this->getFoto(),
            'user' => $this->getUser()->getId()
        );
    } 

}

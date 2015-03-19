<?php

namespace AGUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

use Zend\Math\Rand;

/**
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="aguser_users", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="fk_aguser_users_agacl_roles1_idx", columns={"role_id"})})
 * @ORM\Entity(repositoryClass="AGUser\Repository\UserRepository")
 */
class User
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
     *
     * @ORM\ManyToOne(targetEntity="AGAcl\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id"),
     * })
     */
    private $role;    

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=false)
     */
    private $activationKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    public function __construct(array $options = array()) 
    {
        /*
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
        */
        
        (new Hydrator\ClassMethods)->hydrate($options,$this);
        
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
            
        $this->salt = md5(Rand::getBytes(8, true));
//        $this->setSalt(Rand::getString(64, $this->email, true));
        
        $this->activationKey = md5($this->email.$this->salt);
    }
        
    public function getId() {
        return $this->id;
    }

    public function getRole() {
        return $this->role;
    }
    
    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getActive() {
        return $this->active;
    }

    public function getActivationKey() {
        return $this->activationKey;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }    

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    public function encryptPassword($password)
    {
//        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 999, strlen($password*2)));
        return md5(base64_encode("locked".$password."".strlen($this->email)."".$this->email));
    }
    
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime("now");
    }

    public function setCreatedAt() {
        $this->createdAt = new \DateTime("now");
    }

//    public function toArray()
//    {
//        return (new Hydrator\ClassMethods())->extract($this);
//    }
    
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'role' => $this->getRole()->getId(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'salt' => $this->getSalt(),
            'active' => $this->getActive(),
            'activationKey' => $this->getActivationKey(),
            'updatedAt'=>$this->getUpdatedAt(),
            'createdAt'=>$this->getCreatedAt(),
        );
    }    

}

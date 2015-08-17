<?php

namespace AdministratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User, entity for managing user accounts that can access to the hole app system.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdministrationBundle\Entity\UserRepository")
 * @UniqueEntity("email", message="Other user has the same email.")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string @ORM\Column(type="string",
     *             length=128, nullable=false, unique=true)
     */
    private $nombre;

    /**
     * @var string @ORM\Column(type="string",
     *             length=128, nullable=false, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    private $roles;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active = true;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Producto")
     */
    private $favoritos;

    /**
     * @ORM\ManyToMany(targetEntity="MainBundle\Entity\Producto",
     * inversedBy="pedidopor")
     */
    private $pedido;

    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->roles = new ArrayCollection();
        $this->favoritos = new ArrayCollection();
        $this->pedido = new ArrayCollection();
    }

    //
    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Administrador
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Administrador
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Administrador
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Administrador
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(
            array(
                $this->id,
                $this->username,
                $this->password,
            ));
        // see section on salt below
        // $this->salt,
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) =
        // see section on salt below
        // $this->salt
        unserialize($serialized);
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add roles.
     *
     * @param \PedidosBundle\Entity\Role $roles
     *
     * @return Usuario
     */
    public function addRole(\AdministratorBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles.
     *
     * @param \PedidosBundle\Entity\Role $roles
     */
    public function removeRole(\AdministratorBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Add favoritos.
     *
     * @param \PedidosBundle\Entity\Producto $favoritos
     *
     * @return Usuario
     */
    public function addFavorito(\MainBundle\Entity\Producto $favoritos)
    {
        $this->favoritos[] = $favoritos;

        return $this;
    }

    /**
     * Remove favoritos.
     *
     * @param \PedidosBundle\Entity\Producto $favoritos
     */
    public function removeFavorito(\MainBundle\Entity\Producto $favoritos)
    {
        $this->favoritos->removeElement($favoritos);
    }

    /**
     * Get favoritos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoritos()
    {
        return $this->favoritos;
    }

    /**
     * Add pedido.
     *
     * @param \PedidosBundle\Entity\Producto $pedido
     *
     * @return Usuario
     */
    public function addPedido(\MainBundle\Entity\Producto $pedido)
    {
        $this->pedido[] = $pedido;

        return $this;
    }

    /**
     * Remove pedido.
     *
     * @param \PedidosBundle\Entity\Producto $pedido
     */
    public function removePedido(\MainBundle\Entity\Producto $pedido)
    {
        $this->pedido->removeElement($pedido);
    }

    /**
     * Get pedido.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedido()
    {
        return $this->pedido;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: bjnash
 * Date: 7/29/16
 * Time: 2:35 PM
 */
namespace User\Entity;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Rbac\Role\RoleInterface;

/**
 * @ORM\Entity
 *
 */
interface UserInterface
{
    public function getArrayCopy();

    public function exchangeArray(array $array);

    /**
     * @return Uuid
     */
    public function getUuid();

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid);

    /**
     * @return mixed
     */
    public function getAddress1();

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1);

    /**
     * @return mixed
     */
    public function getAddress2();

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2);

    /**
     * @return mixed
     */
    public function getCity();

    /**
     * @param mixed $city
     */
    public function setCity($city);

    /**
     * @return mixed
     */
    public function getCountry();

    /**
     * @param mixed $country
     */
    public function setCountry($country);

    /**
     * @return mixed
     */
    public function getCreated();

    /**
     * @param mixed $created
     */
    public function setCreated($created);

    /**
     * @return mixed
     */
    public function getDateConvention();

    /**
     * @param mixed $dateConvention
     */
    public function setDateConvention($dateConvention);

    /**
     * @return mixed
     */
    public function getDob();

    /**
     * @param mixed $dob
     */
    public function setDob($dob);

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $email
     */
    public function setEmail($email);

    /**
     * @return mixed
     */
    public function getFirstname();

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname);

    /**
     * @return mixed
     */
    public function getGender();

    /**
     * @param mixed $gender
     */
    public function setGender($gender);

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getIdentityNumber();

    /**
     * @param mixed $identityNumber
     */
    public function setIdentityNumber($identityNumber);

    /**
     * @return mixed
     */
    public function getInviteCode();

    /**
     * @param mixed $inviteCode
     */
    public function setInviteCode($inviteCode);

    /**
     * @return mixed
     */
    public function getIsMember();

    /**
     * @param mixed $isMember
     */
    public function setIsMember($isMember);

    /**
     * @return mixed
     */
    public function getModified();

    /**
     * @param mixed $modified
     */
    public function setModified($modified);

    /**
     * @return mixed
     */
    public function getParent();

    /**
     * @param mixed $parent
     */
    public function setParent($parent);

    /**
     * @return mixed
     */
    public function getPassword();

    /**
     * @param mixed $password
     */
    public function setPassword($password);

    /**
     * @return mixed
     */
    public function getPostCode();

    /**
     * @param mixed $postCode
     */
    public function setPostCode($postCode);

    /**
     * {@inheritDoc}
     */
    public function getRoles();

    /**
     * Set the list of roles
     * @param Collection $roles
     */
    public function setRoles(Collection $roles);

    /**
     * Add one role to roles list
     * @param \Rbac\Role\RoleInterface $role
     */
    public function addRole(RoleInterface $role);

    /**
     * Add Roles to the collection
     * @param Collection $roles
     */
    public function addRoles(Collection $roles);

    /**
     * @return mixed
     */
    public function getState();

    /**
     * @param mixed $state
     */
    public function setState($state);

    /**
     * @return mixed
     */
    public function getSurname();

    /**
     * @param mixed $surname
     */
    public function setSurname($surname);

    /**
     * @return mixed
     */
    public function getTakeTest();

    /**
     * @param mixed $takeTest
     */
    public function setTakeTest($takeTest);

    /**
     * @return mixed
     */
    public function getTell();

    /**
     * @param mixed $tell
     */
    public function setTell($tell);

    /**
     * @return mixed
     */
    public function getTest();

    /**
     * @param mixed $test
     */
    public function setTest($test);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param mixed $title
     */
    public function setTitle($title);
}

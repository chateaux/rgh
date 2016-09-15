<?php
namespace User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Rbac\Role\RoleInterface;
use Zend\Stdlib\ArraySerializableInterface;
use ZfcRbac\Identity\IdentityInterface;

/**
 * @ORM\Entity
 *
 */
class User implements
    IdentityInterface,
    ArraySerializableInterface,
UserInterface
{
    public function getArrayCopy()
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->getUuid(),
            'title' => $this->getTitle(),
            'firstname' => $this->getFirstname(),
            'surname' => $this->getSurname(),
            'email' => $this->getEmail(),
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'city' => $this->getCity(),
            'postCode' => $this->getPostCode(),
            'tell' => $this->getTell(),
            'password' => $this->getPassword(),
            'gender' => $this->getGender(),
            'state' => $this->getState(),
            'dob' => $this->getDob(),
            'created' => $this->getCreated(),
            'modified' => $this->getModified(),
        ];
    }

    public function exchangeArray(array $array)
    {
        throw new \Exception('exchangeArray not implemented');
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid_binary", unique=true, nullable=false)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false, name="email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false, name="password")
     */
    private $password;

    /**
     * @ORM\Column(type="string", unique=true, length=32, nullable=false, options={"fixed":true})
     */
    private $activationCode;

    /**
     * @ORM\Column(type="string", nullable=true, name="title")
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true, name="firstname")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", nullable=true, name="lastname")
     */
    private $surname;

    /**
     * @ORM\Column(type="string", nullable=true, name="dob")
     */
    private $dob;

    /**
     * @ORM\Column(type="boolean", nullable=true, name="gender")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true, name="id_number")
     */
    private $identityNumber;

    /**
     * @ORM\Column(type="string", nullable=true, name="address1")
     */
    private $address1;

    /**
     * @ORM\Column(type="string", nullable=true, name="address2")
     */
    private $address2;

    /**
     * @ORM\Column(type="string", nullable=true, name="post_code")
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", nullable=true, name="city")
     */
    private $city;

    /**
     * @ORM\Column(type="string", nullable=true, name="tell")
     */
    private $tell;

    /**
     * @ORM\Column(type="smallint", nullable=true, name="state")
     */
    private $state;

    /**
     * @ORM\Column(type="smallint", nullable=true, name="is_member")
     */
    private $isMember;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $dateConvention;

    /**
     * @ORM\Column(type="string", nullable=true, name="invite_code")
     */
    private $inviteCode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @ORM\OneToMany(targetEntity="User\Entity\User", mappedBy="parent")
     */
    private $referrals;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\Test", mappedBy="author")
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="Education\Entity\TakeTest", mappedBy="user")
     */
    private $takeTest;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="referrals")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\Country")
     * @ORM\JoinColumn(name="countries_id", referencedColumnName="id", nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="User\Entity\HierarchicalRole")
     * @ORM\JoinTable(
     *     name="rbu_users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    public function __construct()
    {
        $this->roles  = new ArrayCollection();
    }

    /**
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getDateConvention()
    {
        return $this->dateConvention;
    }

    /**
     * @param mixed $dateConvention
     */
    public function setDateConvention($dateConvention)
    {
        $this->dateConvention = $dateConvention;
    }

    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param mixed $dob
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdentityNumber()
    {
        return $this->identityNumber;
    }

    /**
     * @param mixed $identityNumber
     */
    public function setIdentityNumber($identityNumber)
    {
        $this->identityNumber = $identityNumber;
    }

    /**
     * @return mixed
     */
    public function getInviteCode()
    {
        return $this->inviteCode;
    }

    /**
     * @param mixed $inviteCode
     */
    public function setInviteCode($inviteCode)
    {
        $this->inviteCode = $inviteCode;
    }

    /**
     * @return mixed
     */
    public function getIsMember()
    {
        return $this->isMember;
    }

    /**
     * @param mixed $isMember
     */
    public function setIsMember($isMember)
    {
        $this->isMember = $isMember;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param mixed $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return  $this->roles->toArray();
    }

    /**
     * Set the list of roles
     * @param Collection $roles
     */
    public function setRoles(Collection $roles)
    {
        $this->roles->clear();
        foreach ($roles as $role) {
            $this->roles[] = $role;
        }
    }

    /**
     * Add one role to roles list
     * @param \Rbac\Role\RoleInterface $role
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles[] = $role;
    }

    /**
     * Add Roles to the collection
     * @param Collection $roles
     */
    public function addRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->roles->add($role);
        }
    }


    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getTakeTest()
    {
        return $this->takeTest;
    }

    /**
     * @param mixed $takeTest
     */
    public function setTakeTest($takeTest)
    {
        $this->takeTest = $takeTest;
    }

    /**
     * @return mixed
     */
    public function getTell()
    {
        return $this->tell;
    }

    /**
     * @param mixed $tell
     */
    public function setTell($tell)
    {
        $this->tell = $tell;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set activationCode
     *
     * @param string $activationCode
     *
     * @return User
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;

        return $this;
    }

    /**
     * Get activationCode
     *
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * Add referral
     *
     * @param \User\Entity\User $referral
     *
     * @return User
     */
    public function addReferral(\User\Entity\User $referral)
    {
        $this->referrals[] = $referral;

        return $this;
    }

    /**
     * Remove referral
     *
     * @param \User\Entity\User $referral
     */
    public function removeReferral(\User\Entity\User $referral)
    {
        $this->referrals->removeElement($referral);
    }

    /**
     * Get referrals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReferrals()
    {
        return $this->referrals;
    }

    /**
     * Add test
     *
     * @param \Education\Entity\Test $test
     *
     * @return User
     */
    public function addTest(\Education\Entity\Test $test)
    {
        $this->test[] = $test;

        return $this;
    }

    /**
     * Remove test
     *
     * @param \Education\Entity\Test $test
     */
    public function removeTest(\Education\Entity\Test $test)
    {
        $this->test->removeElement($test);
    }

    /**
     * Add takeTest
     *
     * @param \Education\Entity\TakeTest $takeTest
     *
     * @return User
     */
    public function addTakeTest(\Education\Entity\TakeTest $takeTest)
    {
        $this->takeTest[] = $takeTest;

        return $this;
    }

    /**
     * Remove takeTest
     *
     * @param \Education\Entity\TakeTest $takeTest
     */
    public function removeTakeTest(\Education\Entity\TakeTest $takeTest)
    {
        $this->takeTest->removeElement($takeTest);
    }

    /**
     * Remove role
     *
     * @param \User\Entity\HierarchicalRole $role
     */
    public function removeRole(\User\Entity\HierarchicalRole $role)
    {
        $this->roles->removeElement($role);
    }
}

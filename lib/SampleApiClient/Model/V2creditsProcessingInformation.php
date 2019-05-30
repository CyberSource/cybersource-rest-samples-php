<?php
/**
 * V2creditsProcessingInformation
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSource
 
 */

namespace CybSource\SampleApiClient\Model;

use \ArrayAccess;

/**
 * V2creditsProcessingInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 
 */
class V2creditsProcessingInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $ModelName = 'v2credits_processingInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Types = [
        'commerceIndicator' => 'string'
        
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Formats = [
        'commerceIndicator' => null
    ];

    public static function Types()
    {
        return self::$Types;
    }

    public static function Formats()
    {
        return self::$Formats;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'commerceIndicator' => 'commerceIndicator'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'commerceIndicator' => 'setCommerceIndicator'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'commerceIndicator' => 'getCommerceIndicator'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['commerceIndicator'] = isset($data['commerceIndicator']) ? $data['commerceIndicator'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['commerceIndicator']) && (strlen($this->container['commerceIndicator']) > 20)) {
            $invalid_properties[] = "invalid value for 'commerceIndicator', the character length must be smaller than or equal to 20.";
        }

       

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if (strlen($this->container['commerceIndicator']) > 20) {
            return false;
        }
        
        return true;
    }


    /**
     * Gets commerceIndicator
     * @return string
     */
    public function getCommerceIndicator()
    {
        return $this->container['commerceIndicator'];
    }

    /**
     * Sets commerceIndicator
     * @param string $commerceIndicator Type of transaction. Some payment card companies use this information when determining discount rates. When you omit this field for **Ingenico ePayments**, the processor uses the default transaction type they have on file for you instead of the default value listed here.
     * @return $this
     */
    public function setCommerceIndicator($commerceIndicator)
    {
        if (!is_null($commerceIndicator) && (strlen($commerceIndicator) > 20)) {
            throw new \InvalidArgumentException('invalid length for $commerceIndicator when calling V2creditsProcessingInformation., must be smaller than or equal to 20.');
        }

        $this->container['commerceIndicator'] = $commerceIndicator;

        return $this;
    }

    
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\CybSource\SampleApiClient\controller\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\CybSource\SampleApiClient\controller\ObjectSerializer::sanitizeForSerialization($this));
    }
}



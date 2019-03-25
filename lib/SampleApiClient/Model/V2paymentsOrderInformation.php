<?php
/**
 * V2paymentsOrderInformation
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSource
 
 */

namespace CybSource\SampleApiClient\Model;

use \ArrayAccess;

/**
 * V2paymentsOrderInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource

 */
class V2paymentsOrderInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $ModelName = 'v2payments_orderInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Types = [
        'amountDetails' => '\CyberSource\Model\V2paymentsOrderInformationAmountDetails',
        'billTo' => '\CyberSource\Model\V2paymentsOrderInformationBillTo'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Formats = [
        'amountDetails' => null,
        'billTo' => null
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
        'amountDetails' => 'amountDetails',
        'billTo' => 'billTo'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'amountDetails' => 'setAmountDetails',
        'billTo' => 'setBillTo'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'amountDetails' => 'getAmountDetails',
        'billTo' => 'getBillTo'
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
        $this->container['amountDetails'] = isset($data['amountDetails']) ? $data['amountDetails'] : null;
        $this->container['billTo'] = isset($data['billTo']) ? $data['billTo'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

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

        return true;
    }


    /**
     * Gets amountDetails
     * @return \CyberSource\Model\V2paymentsOrderInformationAmountDetails
     */
    public function getAmountDetails()
    {
        return $this->container['amountDetails'];
    }

    /**
     * Sets amountDetails
     * @param \CyberSource\Model\V2paymentsOrderInformationAmountDetails $amountDetails
     * @return $this
     */
    public function setAmountDetails($amountDetails)
    {
        $this->container['amountDetails'] = $amountDetails;

        return $this;
    }

    /**
     * Gets billTo
     * @return \CyberSource\Model\V2paymentsOrderInformationBillTo
     */
    public function getBillTo()
    {
        return $this->container['billTo'];
    }

    /**
     * Sets billTo
     * @param \CyberSource\Model\V2paymentsOrderInformationBillTo $billTo
     * @return $this
     */
    public function setBillTo($billTo)
    {
        $this->container['billTo'] = $billTo;

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



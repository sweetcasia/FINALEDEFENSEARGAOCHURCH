<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Assistants
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\Assistants\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;
use Twilio\Rest\Assistants\V1\Session\MessageList;


/**
 * @property string $id
 * @property string $accountSid
 * @property string $assistantId
 * @property bool $verified
 * @property string $identity
 * @property \DateTime $dateCreated
 * @property \DateTime $dateUpdated
 */
class SessionInstance extends InstanceResource
{
    protected $_messages;

    /**
     * Initialize the SessionInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $id
     */
    public function __construct(Version $version, array $payload, string $id = null)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'id' => Values::array_get($payload, 'id'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'assistantId' => Values::array_get($payload, 'assistant_id'),
            'verified' => Values::array_get($payload, 'verified'),
            'identity' => Values::array_get($payload, 'identity'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
        ];

        $this->solution = ['id' => $id ?: $this->properties['id'], ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return SessionContext Context for this SessionInstance
     */
    protected function proxy(): SessionContext
    {
        if (!$this->context) {
            $this->context = new SessionContext(
                $this->version,
                $this->solution['id']
            );
        }

        return $this->context;
    }

    /**
     * Fetch the SessionInstance
     *
     * @return SessionInstance Fetched SessionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): SessionInstance
    {

        return $this->proxy()->fetch();
    }

    /**
     * Access the messages
     */
    protected function getMessages(): MessageList
    {
        return $this->proxy()->messages;
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Assistants.V1.SessionInstance ' . \implode(' ', $context) . ']';
    }
}


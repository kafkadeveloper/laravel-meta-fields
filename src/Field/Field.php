<?php

namespace Sackrin\Meta\Field;

abstract class Field {

    public $parentField;

    public $options = [];

    public $value;

    public $position;

    public $hydrated = false;

    public static $defaults = [
        'machine' => '',
        'label' => '',
        'instructions' => '',
        'required' => false,
        'default_value' => ''
    ];

    public function __construct($machine) {
        // Populate with the defaults for the field
        $this->options = static::$defaults;
        // Update the field options values
        $this->options['machine'] = $machine;
    }

    public function setParentField($parentField) {
        // Save the parentField for future use
        $this->parentField = $parentField;
        // Return for chaining
        return $this;
    }

    public function getPath() {
        // Determine the machine code
        $machine = $this->options['machine'];
        // If a parentField object was returned
        if ($this->parentField) {
            // Merge with the parentField's code
            return $this->parentField->getChildPath($this);
        } // Otherwise return the standard key
        else { return $machine; }
    }

    public function getMachine() {
        // Update the field options values
        return $this->options['machine'];
    }

    public function setOptions($options) {
        // Update the options with the options
        $this->options = array_merge($this->options, $options);
        // Return for chaining
        return $this;
    }

    public function setInstructions($instructions) {
        // Set the setting option value
        $this->options['instructions'] = $instructions;
        // Return for chaining
        return $this;
    }

    public function setRequired($required) {
        // Set the setting option value
        $this->options['required'] = $required;
        // Return for chaining
        return $this;
    }

    public function setDefault($default) {
        // Set the setting option value
        $this->options['default_value'] = $default;
        // Return for chaining
        return $this;
    }

    public function setHydrated($value) {
        // Populate the value
        $this->hydrated = $value;
        // Return for chaining
        return $this;
    }

    public function getPosition() {

        return $this->position;
    }

    public function setPosition($position) {
        // Populate the value
        $this->position = $position;
        // Return for chaining
        return $this;
    }

    public function setValue($value) {
        // Populate the value
        $this->value = $value;
        // Return for chaining
        return $this;
    }

    public function toIndex($collection) {
        // Set the field in the index collection
        $collection->put($this->getPath(), $this);
    }

    public function copy() {
        // Create a new instance of this field object
        $instance = new static($this->options['machine']);
        // Inject the new options
        $instance->setOptions($this->options);
        // Return the copied instance
        return $instance;
    }

    public function hydrate($value) {
        // Create a copy to hydrate
        $hydrated = $this->copy();
        // Hydrate the field
        $hydrated->setValue($value);
        // Set that this is a hydrated field
        $hydrated->setHydrated(true);
        // Return the text value
        return $hydrated;
    }

    abstract public function getValue($formatted=true);


}
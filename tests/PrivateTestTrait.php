<?php
namespace Andriinavrotskii\Hexatest2016\Tests;


trait PrivateTestTrait
{

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Call protected/private propery of a class.
     *
     * @param object &$object    Instantiated object that have proerty.
     * @param string $methodName Propery name to call
     *
     * @return mixed Property value.
     */
    public function getPropertyValue(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $propery = $reflection->getProperty($propertyName);
        $propery->setAccessible(true);

        return $propery->getValue($object);
    }    
}
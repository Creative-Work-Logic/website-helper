<?php

    class clsTraverse{
        use trtBasic;
        
        public function traverseClass($className, $level = 0, $visited = []) {
            try {
                echo "\n Class: {$className} \n";
                $reflectionClass = new ReflectionClass($className);
        
                // Get properties
                $properties = $reflectionClass->getProperties();
                foreach ($properties as $property) {
                    $property->setAccessible(true); // Make private/protected properties accessible
                    $value = $property->getValue(new $className());
        
                    // Detect circular references
                    if (is_object($value) && in_array(spl_object_id($value), $visited, true)) {
                        echo "Property: {$property->getName()} = *RECURSION*\n";
                    } else {
                        echo "Property: {$property->getName()} = " . var_export($value, true) . "\n";
                        if (is_object($value)) {
                            $visited[] = spl_object_id($value);
                            $this->traverseClass(get_class($value), $level + 1, $visited);
                        }
                    }
                }
        
                // Get methods
                $methods = $reflectionClass->getMethods();
                foreach ($methods as $method) {
                    echo "Method: {$method->getName()}()\n";
                }
            } catch (ReflectionException $e) {
                echo "Error: {$e->getMessage()}\n";
            }
        }
    }


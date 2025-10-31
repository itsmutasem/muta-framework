<?php
 namespace Framework;

 use ReflectionClass;
 use Closure;

 class Container
 {
     private array $registry = [];

     public function set(string $name, Closure $value): void
     {
         $this->registry[$name] = $value;
     }

     public function get(string $class_name): object
     {
         if (array_key_exists($class_name, $this->registry)) {
             return $this->registry[$class_name]();
         }

         $reflector = new ReflectionClass($class_name);
         $constructor = $reflector->getConstructor();
         $dependencies = [];
         if ($constructor === null) {
             return new $class_name;
         }
         foreach ($constructor->getParameters() as $parameter) {
             $type = $parameter->getType();
             if ($type->isBuiltin()) {
                 exit("Unable to resolve constructor parameter '" . $parameter->getName() . "' of type '" . $type . "' in class '" . $class_name . "'.");
             }
             $dependencies[] = $this->get($type);
         }

         return new $class_name(...$dependencies);
     }
 }
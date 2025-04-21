<?php

    class clsReflection{
		use trtBasic;
        public $var=array();
        public $cls=array();
        function __construct(){
			
			
		}

        public function show_all_classes($return_array=array()){
			foreach($return_array as $key=>$val){
				$this->show_class_array($val);
			}
		}

		public function show_class_array($return_array=array()){
			//print_r($return_array);
            // Output the information
			echo "Classes:\n";
			foreach ($return_array['classes'] as $class) {
				echo "  - $class\n";
			}

			echo "\nProperties:\n";
			foreach ($return_array['properties'] as $property) {
				echo "  - {$property['visibility']} \${$property['name']}";
				if ($property['default'] !== null) {
					echo " = {$property['default']}";
				}
				echo "\n";
			}

			echo "\nTraits Used:\n";
			foreach ($return_array['traits_used'] as $trait) {
				echo "  - $trait\n";
			}

			echo "\nMethods and Method Parameters:\n";
			foreach ($return_array['methods'] as $index => $method) {
				echo "  - {$method['visibility']} {$method['name']}\n";
				if (!empty($return_array['method_variables'][$index])) {
					echo "    Parameters:\n";
					foreach ($return_array['method_variables'][$index] as $param) {
						echo "      - \${$param['name']}";
						if ($param['default'] !== null) {
							echo " = {$param['default']}";
						}
						echo "\n";
					}
				}
			}

			echo "\nTraits:\n";
			foreach ($return_array['traits'] as $trait) {
				echo "  - $trait\n";
			}

			echo "\nInterfaces:\n";
			foreach ($return_array['interfaces'] as $interface) {
				echo "  - $interface\n";
			}

			echo "\nExtended Classes:\n";
			foreach ($return_array['extended_classes'] as $child => $parent) {//$menu_level[$main_menu_number]
				echo "  - $child extends $parent\n";
			}
        }

        
    }


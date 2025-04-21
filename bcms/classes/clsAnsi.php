<?php

    class clsAnsi{
		use trtBasic;
        public $var=array();
        public $cls=array();
        function __construct(){
			
			
		}


        public function show_colours() {

			$consoleColor = new PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor();

			echo "Colors are supported: " . ($consoleColor->isSupported() ? 'Yes' : 'No') . "\n";
			echo "256 colors are supported: " . ($consoleColor->are256ColorsSupported() ? 'Yes' : 'No') . "\n\n";
			
			if ($consoleColor->isSupported()) {
				foreach ($consoleColor->getPossibleStyles() as $style) {
					echo $consoleColor->apply($style, $style) . "\n";
				}
			}
			
			echo "\n";
			
			if ($consoleColor->are256ColorsSupported()) {
				echo "Foreground colors:\n";
				for ($i = 1; $i <= 255; $i++) {
					echo $consoleColor->apply("color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));
			
					if ($i % 15 === 0) {
						echo "\n";
					}
				}
			
				echo "\nBackground colors:\n";
			
				for ($i = 1; $i <= 255; $i++) {
					echo $consoleColor->apply("bg_color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));
			
					if ($i % 15 === 0) {
						echo "\n";
					}
				}
			
				echo "\n";
			}
		}

		
		// Define ANSI escape code format
		public function ansi($text, $fgColor = null, $bgColor = null, $style = null) {
			$code = '';
			
			if ($style) {
				$code .= $style . ';';
			}
			
			if ($fgColor) {
				$code .= $fgColor . ';';
			}

			if ($bgColor) {
				$code .= $bgColor . ';';
			}

			// Remove the last semicolon
			$code = rtrim($code, ';');
			
			// Return the formatted string with reset (\033[0m) at the end
			return "\033[" . $code . "m" . $text . "\033[0m";
		}

		public function ansi_example(){
		
			// ANSI color codes
			$foregroundColors = [
				'Black' => 30,
				'Red' => 31,
				'Green' => 32,
				'Yellow' => 33,
				'Blue' => 34,
				'Magenta' => 35,
				'Cyan' => 36,
				'White' => 37
			];

			$backgroundColors = [
				'Black' => 40,
				'Red' => 41,
				'Green' => 42,
				'Yellow' => 43,
				'Blue' => 44,
				'Magenta' => 45,
				'Cyan' => 46,
				'White' => 47
			];

			$styles = [
				'Normal' => null,
				'Bold' => 1,
				'Underline' => 4,
				'Blink' => 5,  // Blinking may not work in some terminals
				'Invert' => 7
			];

			echo "\033[2J";  // Clear screen

			// Loop through all combinations of foreground colors, background colors, and styles
			foreach ($styles as $styleName => $styleCode) {
				echo "\n=== Style: $styleName ===\n";
				foreach ($foregroundColors as $fgName => $fgCode) {
					foreach ($backgroundColors as $bgName => $bgCode) {
						echo $this->ansi(" $fgName on $bgName ", $fgCode, $bgCode, $styleCode) . "\n";
					}
				}
			}
		}

		public function show_characters() {
			echo "ASCII Characters (0-127):\n";
			for ($i = 0; $i < 128; $i++) {
				// Show the character with its corresponding ASCII code
				printf("%3d: %s\n", $i, chr($i));
			}

			echo "\n\nExtended ASCII Characters (128-255):\n";

			// Print extended ASCII characters (128-255)
			for ($i = 128; $i < 256; $i++) {
				// Show the character with its corresponding code
				printf("%3d: %s\n", $i, chr($i));
			}
		}

        
    }


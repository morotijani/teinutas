<?php 

	class AllFunctions {
		private $front = 'CKT-';
		
		public function generate_identity_number($id) {
			$thisYr = date("y");
			$thisYr = substr($thisYr, -2);
			$output = $this->front . $thisYr . '-';
			$output = $output . str_pad($id, 5, "0", STR_PAD_LEFT);
			return $output;
		}
	}


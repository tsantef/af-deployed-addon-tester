<?php

	function validate($desc, $test) {

		$message = '';
		
		try { 
			$result = is_object($test) ? $test() : $test;
		} catch (Exception $e) {
			$message =  "- Exception: " . $e->getMessage();
			$result = false;
		}

		echo "<div>$desc? ";
		if ($result) {
			echo "<strong class='pass'>Yes</strong></div>";
		} else {
			die("<strong class='fail'>No</strong> $message</div>");
		}

	}

	function tag($tag, $inner) {
		echo "<$tag>$inner</$tag>";
	}

	function h2($inner) {
		tag("h2", $inner);
	}

	function h3($inner) {
		tag("h3", $inner);
	}

	function pr($thing) {		
		echo "<pre>";
		print_r ($thing);
		echo "</pre>";
	}

	function vr($thing) {		
		echo "<pre>";
		var_dump($thing);
		echo "</pre>";
	}
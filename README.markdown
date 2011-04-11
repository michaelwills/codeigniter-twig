# Twig library for CodeIgniter 2.x

## Installation

First, Create twig cache directory under application/cache; and
give it write permission
	
    $ mkdir -p application/cache/twig
    $ chmod o+w application/cache/twig

Add the Twig config file to application/config/twig.php

Download and extract the Twig library into application/libraries. The directories should look like this

    application/libraries/Twig
    |-- Error
    |-- Extension
    |-- Filter
    |-- Function
    |-- Loader
    |-- Node
    |   `-- Expression
    |       |-- Binary
    |       `-- Unary
    |-- NodeVisitor
    |-- Sandbox
    |-- Test
    `-- TokenParser

## Usage

Put in your controller,

    $this->load->library('twig');
    $data['title'] = "Testing Twig!!";
    $this->twig->display('view.html', $data);
    
## CodeIgniter helper functions

If you want to use CodeIgniter helper functions in Twig templates do this in
your controller.

    $this->load->library('twig'); // load the Twig library
    $this->load->helper('url'); // load the CodeIgniter URL helper
    // map the base_url() function as a Twig function 
    $this->twig->add_function('base_url'); 

Then in your Twig view call the base_url() function like this

    {{ base_url() }}

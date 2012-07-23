glowing-octo-hipster
====================

A PHP program that generates an XML file containing every 30th of June since the Unix Epoch, at 1pm GMT. The program can also parse the generated XML file and generate a second XML file sorted by timestamp in descending order, excluding years that are prime numbers. The timestamps generated should be at 1pm PST.

The generator accepts an optional parameter which specifies where the output should be sent, otherwise it defaults to stdout.

The parser follows the same conventions as the generator (defaults to stdout unless output stream speficied).

## Examples of how these can be run:

### output to stdout
    php generate.php

### output to file
    php generate.php -o=data.xml

### parse the generator output from stdin and output to stdout
    php generate.php | php parse.php

### parse previously generated data and output to file
    php parse.php -i=data.xml -o=parsed.xml

# Contributing

Fork the repository
Make your changes in a feature branch (use git flow)
Send a pull request from your feature branch
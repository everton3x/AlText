# AlText
Easy translate for PHP code

## Introduction
AlText makes it easy to text translation PHP code.

The usage is identical to the PHP gettext (altext ("Inquiry to translate ');) and can be used in conjunction with sprintf and similar functions.

It works with INI files to store the texts in several languages and has a parser which seeks in the source code the texts to translate.

It also has a merger able to compare two files generated by the parser (since translated or not), creating a third file with the new texts found without the deleted texts of PHP code and keeping the already translated.

Its implementation is quite simple, yet flexible.

## Usage
AlText implement in your code is very easy.

For each message to be translated, simply call the altext function (included in altext.php file). For example: ```echo altext ('My own message')```.

AlText can be used in conjunction with other PHP text output functions such as sprintf ().

## Analyzing the source code
AlText has a parser source code (there is a simple implementation of parse.bat parse the file). It analyzes any file the demand for calls altext () function and saves the text passed as a function parameter in a INI file.
That INI file that will be the source of strings translated: just change the text of each message in the INI file to the desired language.

In addition, there is no redundancy in the messages: one message, even appearing several times in the source code is added only once in the INI file.

## Merging translation files
AlText also has an implementation of a merger for the translation files.

For example, if you have translated your application and then changed some messages, you run the parser again and executes the merger (there is a simple implementation of it in merge.bat). The merger will create a new INI file with all new messages without the deleted messages and messages that remain unchanged, these have translated. So, you only need to translate new messages.

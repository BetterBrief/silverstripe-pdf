SilverStripe PDF Extension
================

Have you ever wanted to deliver your SilverStripe website's content in a slow and bloated format? If you have, this module fulfils your needs!


### Requirements
* [wkhtmltopdf](http://wkhtmltopdf.org/) will take the HTML you generate and create a PDF document out of it using Webkit as the rendering engine.
  * The version of the binary you use is dependent on your architecture. To find out the architecture your server is running, type `arch` in your terminal window. With the [development environment](https://github.com/BetterBrief/vagrant-skeleton), we use **amd64**.
  * It is advisable to get the following packages to avoid graphic / font issues with rendering: fontconfig, libXrender, libXext and urw-fonts. You can get these on CentOS with `yum install fontconfig libXrender libXext urw-fonts`
  * 
* [Knp's Snappy](https://github.com/KnpLabs/snappy/tree/0.2.0) provides the bridge functionality between wkhtmltopdf and PHP

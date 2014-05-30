SilverStripe PDF Extension
================

Have you ever wanted to deliver your SilverStripe website's content in a slow and bloated format? If you have, this module fulfils your needs!

### Install
1. Use [Composer](http://getcomposer.org): `composer require betterbrief/silverstripe-pdf`
2. Install the correct version of `wkhtmltopdf`...
  * The version of the binary you use is dependent on your architecture. To find out the architecture your server is running, type `arch` in your terminal window. With the [development environment](https://github.com/BetterBrief/vagrant-skeleton), we use **amd64**.

### Set up
1. Once you have got the module from composer, you will need to get the wkhtmltopdf binary and then configure PDFExtension to point to it. The composer suggestions give you your options.
2. Add `PDFExtension` to the objects you wish to render to PDF.

#### Config example
```yaml
PDFExtension:
  wkhtmltopdf_binary: '/vagrant/www/vendor/bin/wkhtmltopdf-amd64'
MyDataObject:
  extensions:
    - PDFExtension
```

### Use it
1. Author your template file called `MyDataObject_pdf.ss` in a suitable directory within your templates folder. Note that you can override this name if you wish to do so.
2. Congratulations, you can now call `MyDataObject->generatePDF()` and get your PDF data.
   * If you wish to send the output to the browser, you'll need to set your response body to `generatePDF()`'s response, use `SS_HTTPResponse->addHeader('Content-Type', 'application/pdf')`.
   * To force a download, `SS_HTTPResponse->addHeader('Content-Disposition', 'attachment')`

### Configuration

You can configure generation on a call-by-call basis by modifying the `PDFExtension->generatePDF()` parameters.
  * Use the `$userOptions` parameter to pass in Snappy / wkhtmltopdf options. [Here's the full list.](http://wkhtmltopdf.org/usage/wkhtmltopdf.txt)
  * Use `$variables` to pass in your standard SSViewer template variables. Note that by default `enable-javascript` is turned off.

|Config Option|Default|How to use|
--------------|-------|----------|
|`wkhtmltopdf_binary`|`null`|Set this to the absolute location of wkhtmltopdf, otherwise nothing will work.|
|`render_host`|`http://localhost/`|As the page is generated on the server, the public facing host will typically not be accessible, and instead be localhost. You may want to change this when deploying to distributed environments.|

### Things to note
* Pages are generated in the context of the current session. So if the requesting user is a logged in administrator, the PDF will be generated with that member's state and permission level.
* It is advisable to get the following packages to avoid graphic / font issues with rendering: fontconfig, libXrender, libXext and urw-fonts. You can get these on CentOS with `yum install fontconfig libXrender libXext urw-fonts`

### Requirements
* [wkhtmltopdf](http://wkhtmltopdf.org/) will take the HTML you generate and create a PDF document out of it using Webkit as the rendering engine.
* [Knp's Snappy](https://github.com/KnpLabs/snappy/tree/0.2.0) provides the bridge functionality between wkhtmltopdf and PHP

### Licensing
* silverstripe-pdf's code is made available to you under the BSD license (see [LICENSE](LICENSE))
* As of 2014-05-30, Knp Snappy is under the MIT license
* As of 2014-05-30, wkhtmltopdf is under the LGPL license.

<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">

    <title>QZ Tray Sample Page</title>
</head>

<!-- Required scripts -->
<script type="text/javascript" src="/print/js/qz-tray.js"></script>

<!-- Pollyfills -->
<script type="text/javascript" src="/print/js/sample/promise-polyfill-8.1.3.min.js"></script>
<script type="text/javascript" src="/print/js/sample/whatwg-fetch-3.0.0.min.js"></script>

<!-- Page styling -->
<script type="text/javascript" src="/print/js/sample/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/print/js/sample/bootstrap.min.js"></script>
<link rel="stylesheet" href="/print/css/font-awesome.min.css" />
<link rel="stylesheet" href="/print/css/bootstrap.min.css" />
<link rel="stylesheet" href="/print/css/style.css" />
<link rel="stylesheet" href="/print/css/gh-fork-ribbon.min.css" />

<script src="https://cdn.rawgit.com/kjur/jsrsasign/c057d3447b194fa0a3fdcea110579454898e093d/jsrsasign-all-min.js">
</script>
<script src="print/js/signing-message.js"></script>


<body id="qz-page" role="document">
<a class="github-fork-ribbon" href="https://github.com/qzind/tray" data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>

<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="https://qz.io/"><span class="fa fa-print"></span>&nbsp;qz.</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- cheap way to avoid reimplementing the php menu -->
                <li><a href="#">Demo Mode</a></li>
                <li><a href="https://qz.io/api/" target="_docs">API</a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;"></div>
<div id="qz-pin" style="position: fixed; width: 30%; margin: 0 66% 0 4%; z-index: 900;"></div>

<div class="container" role="main">

    <div class="row">
        <h1 id="title" class="page-header">QZ Tray v<span id="qz-version">0</span></h1>
    </div>

    <div class="row spread">
        <div class="col-md-4">
            <div id="qz-connection" class="panel panel-default">
                <div class="panel-heading">
                    <button class="close tip" data-toggle="tooltip" title="Launch QZ" id="launch" href="#" onclick="launchQZ();" style="display: none;">
                        <i class="fa fa-external-link"></i>
                    </button>
                    <h3 class="panel-title">
                        Connection: <span id="qz-status" class="text-muted" style="font-weight: bold;">Unknown</span>
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="btn-toolbar">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success" onclick="startConnection();">Connect</button>
                            <button id="toggleConnectionGroup" type="button" class="btn btn-success"
                                    onclick="checkGroupActive('toggleConnectionGroup', 'connectionGroup'); $('#connectionHost').select();"
                                    data-toggle="tooltip" data-placement="bottom" title="Connect to QZ Tray running on a print server"><span class="fa fa-caret-down"></span>&nbsp;</button>
                            <button type="button" class="btn btn-warning" onclick="endConnection();">Disconnect</button>
                        </div>
                        <button type="button" class="btn btn-info" onclick="listNetworkDevices();">Network Info</button>
                    </div>
                    <div class="form-group" id="connectionGroup">
                        <hr>
                        <label for="connectionHost">Connect to host:</label>
                        <input type="text" id="connectionHost" value="localhost" class="form-control" />
                        <div class="form-group form-inline">
                            <label for="connectionUsingSecure" data-toggle="tooltip" title="HTTPS Only: When disabled, allows secure pages to connect to insecure locations.">
                                Secure
                            </label>
                            <input checked type="checkbox" id="connectionUsingSecure" class="pull-right"/>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Printer</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label for="printerSearch">Search:</label>
                        <input type="text" id="printerSearch" value="zebra" class="form-control" />
                    </div>
                    <div class="form-group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="findPrinter($('#printerSearch').val(), true);">Find Printer</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="findDefaultPrinter(true);">Find Default Printer</button>
                            <button type="button" class="btn btn-default btn-sm" onclick="findPrinters();">Find All Printers</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="detailPrinters();">Get Printer Details</button>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>Current printer:</label>
                        <div id="configPrinter">NONE</div>
                    </div>
                    <div class="form-group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-sm" onclick="setPrinter($('#printerSearch').val());">Set To Search</button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#askFileModal">Set To File</button>
                            <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#askHostModal">Set To Host</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="nav nav-tabs" role="tablist">
                <li id="rawTab" role="presentation" class="active"><a href="#rawContent" role="tab" data-toggle="tab">Raw Printing</a></li>
                <li id="pxlTab" role="presentation"><a href="#pxlContent" role="tab" data-toggle="tab">Pixel Printing</a></li>
                <li id="serialTab" role="presentation"><a href="#serialContent" role="tab" data-toggle="tab">Serial</a></li>
                <li id="socketTab" role="presentation"><a href="#socketContent" role="tab" data-toggle="tab">Socket</a></li>
                <li id="usbTab" role="presentation"><a href="#usbContent" role="tab" data-toggle="tab">USB</a></li>
                <li id="hidTab" role="presentation"><a href="#hidContent" role="tab" data-toggle="tab">HID</a></li>
                <li id="statusTab" role="presentation"><a href="#statusContent" role="tab" data-toggle="tab">Printer Status</a></li>
                <li id="fileTab" role="presentation"><a href="#fileContent" role="tab" data-toggle="tab">Files</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="rawContent" class="tab-pane active col-md-8">
                <h3>Raw Printing</h3>

                <div class="row">
                    <div class="col-md-12">
                        <a href="https://qz.io/wiki/What-is-Raw-Printing" target="new">What is Raw Printing?</a>

                        <span style="float: right;">
                            <a href="javascript:findPrinter('Zebra', true, 'ZPL');">Zebra</a> |
                            <a href="javascript:findPrinter('ZDesigner', true, 'ZPL');">ZDesigner</a> |
                            <a href="javascript:findPrinter('SATO', true, 'SBPL');">SATO</a> |
                            <a href="javascript:findPrinter('Epson', true, 'ESCPOS');">Epson</a> |
                            <a href="javascript:findPrinter('Citizen', true, 'ESCPOS');">Citizen</a> |
                            <a href="javascript:findPrinter('Star', true, 'ESCPOS');">Star</a>
                        </span>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Raw Language</label>
                            <div>
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="Eltron Programming Language">
                                    <input type="radio" name="pLanguage" id="pLangEPL" value="EPL" onclick="updateRawButtons()"/>
                                    EPL2
                                </label>
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="Zebra Programming Language">
                                    <input type="radio" name="pLanguage" id="pLangZPL" value="ZPL" onclick="updateRawButtons()"/>
                                    ZPLII
                                </label>
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="Epson Standard Code for POS Printers">
                                    <input type="radio" name="pLanguage" id="pLangESCPOS" value="ESCPOS" onclick="updateRawButtons()"/>
                                    ESC/POS
                                </label>
                                <br />
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="Eltron Printer Program Command Language">
                                    <input type="radio" name="pLanguage" id="pLangEPCL" value="EPCL" onclick="updateRawButtons()"/>
                                    EPCL
                                </label>
                                <label>
                                    <input type="radio" name="pLanguage" id="pLangEVOLIS" value="EVOLIS" onclick="updateRawButtons()"/>
                                    Evolis
                                </label>
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="SATO Barcode Printer Language">
                                    <input type="radio" name="pLanguage" id="pLangSBPL" value="SBPL" onclick="updateRawButtons()"/>
                                    SBPL
                                </label>
                                <label class="tip" data-toggle="tooltip" title="" data-original-title="Printronix Graphics Language">
                                    <input type="radio" name="pLanguage" id="pLangPGL" value="PGL" onclick="updateRawButtons()"/>
                                    PGL
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Print From File</label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printFile('zpl_sample.txt');">zpl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('fgl_sample.txt');">fgl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('epl_sample.txt');">epl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('sbpl_sample.txt');">sbpl_sample.txt</button>
                                <button type="button" class="btn btn-default" onclick="printFile('pgl_sample.txt');">pgl_sample.txt</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label>Print Raw Data</label>
                            </div>
                            <div id="rawCommandsGroup" class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printCommand();">Commands</button>
                                <button type="button" class="btn btn-default" onclick="printHex();">Hex</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Raster Print</label>
                            </div>
                            <div id="rawRasterGroup" class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printRawImage();">Image</button>
                                <button type="button" class="btn btn-default" onclick="printRawPDF();">PDF</button>
                                <button type="button" class="btn btn-default" onclick="printRawHTML();">HTML</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Other Data Formats</label>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" onclick="printBase64();">Base64 (EPL)</button>
                                <button type="button" class="btn btn-default" onclick="printXML();">XML (ZPL)</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <fieldset>
                                    <legend>Config Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="rawEncoding">Encoding</label>
                                                <input type="text" id="rawEncoding" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="rawSpoolEnd">End Of Doc</label>
                                                <input type="text" id="rawSpoolEnd" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="rawPerSpool">Per Spool</label>
                                                <input type="number" id="rawPerSpool" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label class="tip" for="rawForceRaw" data-toggle="tooltip" title="Bypass printer driver (CUPS only)">
                                                    Force Raw
                                                </label>
                                                <input type="checkbox" id="rawForceRaw" class="pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="rawCopies">Copies</label>
                                                <input type="number" id="rawCopies" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="tip" for="rawJobName" data-toggle="tooltip" title="Job title as it appears in print queue">
                                                    Job Name
                                                </label>
                                                <input type="text" id="rawJobName" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr />

                                <fieldset>
                                    <legend>Printer Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="pX">Image X</label>
                                                <input type="number" id="pX" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pY">Image Y</label>
                                                <input type="number" id="pY" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label class="tip" for="pDotDensity" data-toggle="tooltip" title="For ESCPOS only">Dot Density</label>
                                                <input type="text" id="pDotDensity" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pXml">XML Tag</label>
                                                <input type="text" id="pXml" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pRawWidth" class="tip" data-toggle="tooltip" title="In pixels">Render Width</label>
                                                <input type="number" id="pRawWidth" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pRawHeight" class="tip" data-toggle="tooltip" title="In pixels">Render Height</label>
                                                <input type="number" id="pRawHeight" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetRawOptions();">Reset</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pxlContent" class="tab-pane col-md-8">
                <h3>Pixel Printing</h3>

                <div class="row">
                    <div class="col-md-12">
                        <a href="https://qz.io/wiki/2.0-pixel-printing" target="new">What is Pixel Printing?</a>

                        <span style="float: right;">
                            <a href="javascript:findPrinter('XPS', true);">Microsoft XPS</a> |
                            <a href="javascript:findPrinter('PDF', true);">PDF</a>
                        </span>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="printHTML();">Print HTML</button>
                            <button type="button" class="btn btn-default" onclick="printPDF();">Print PDF</button>
                            <button type="button" class="btn btn-default" onclick="printImage();">Print Image</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <fieldset>
                                    <legend>Config Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group form-inline">
                                                <label for="pxlColorType">Color Type</label>
                                                <select id="pxlColorType" class="form-control pull-right">
                                                    <option value="color">Color</option>
                                                    <option value="grayscale">Grayscale</option>
                                                    <option value="blackwhite">Black & White</option>
                                                </select>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlCopies">Copies</label>
                                                <input type="number" id="pxlCopies" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlDuplex"> Duplex</label>
                                                <select id="pxlDuplex" class="form-control pull-right">
                                                    <option value="">Single Sided</option>
                                                    <option value="duplex">Double Sided</option>
                                                    <option value="long-edge">Two Sided (Long Edge)</option>
                                                    <option value="short-edge">Two Sided (Short Edge)</option>
                                                    <option value="tumble">Tumble</option>
                                                </select>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlInterpolation">Interpolation</label>
                                                <select id="pxlInterpolation" class="form-control pull-right">
                                                    <option value="">Default</option>
                                                    <option value="bicubic">Bicubic</option>
                                                    <option value="bilinear">Bilinear</option>
                                                    <option value="nearest-neighbor">Nearest Neighbor</option>
                                                </select>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="tip" for="pxlJobName" data-toggle="tooltip" title="Job title as it appears in print queue">
                                                    Job Name
                                                </label>
                                                <input type="text" id="pxlJobName" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlLegacy">Legacy Printing</label>
                                                <input type="checkbox" id="pxlLegacy" class="pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlOrientation">Orientation</label>
                                                <select id="pxlOrientation" class="form-control pull-right">
                                                    <option value="">Default</option>
                                                    <option value="portrait">Portrait</option>
                                                    <option value="landscape">Landscape</option>
                                                    <option value="reverse-landscape">Landscape - Reverse</option>
                                                </select>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlPaperThickness">Paper<br />Thickness</label>
                                                <input disabled type="number" step="any" id="pxlPaperThickness" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlPrinterTray">Printer Tray</label>
                                                <input type="text" id="pxlPrinterTray" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlRasterize">Rasterize</label>
                                                <input type="checkbox" id="pxlRasterize" class="pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlRotation">Rotation</label>
                                                <input type="number" step="any" id="pxlRotation" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlSpoolSize">Per Spool</label>
                                                <input type="number" id="pxlSpoolSize" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pxlDensity" class="tip" data-toggle="tooltip"
                                                       title="DPI, DPCM, or DPMM depending on units specified">Density</label>
                                                (
                                                <label for="pxlDensityAsymm" class="inline">Asymmetric:</label>
                                                <input type="checkbox" id="pxlDensityAsymm" onclick="checkGroupActive('pxlDensityAsymm', 'pxlDensityGroup', 'pxlDensity');">
                                                )
                                                <input id="pxlDensity" class="form-control" />
                                            </div>
                                            <div class="inline" id="pxlDensityGroup">
                                                <div class="form-group form-inline">
                                                    <label for="pxlCrossDensity">&nbsp; Cross:</label>
                                                    <input type="number" id="pxlCrossDensity" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlFeedDensity">&nbsp; Feed:</label>
                                                    <input type="number" id="pxlFeedDensity" class="form-control pull-right" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Units</label>
                                                <div>
                                                    <label>
                                                        <input type="radio" name="pxlUnits" id="pxlUnitsIN" value="in" />
                                                        IN
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="pxlUnits" id="pxlUnitsMM" value="mm" />
                                                        MM
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="pxlUnits" id="pxlUnitsCM" value="cm" />
                                                        CM
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="pxlScale">Scale Content:</label>
                                                <input type="checkbox" id="pxlScale" class="pull-right" />
                                            </div>

                                            <div class="form-group">
                                                <label for="pxlMargins" class="tip" data-toggle="tooltip" title="In relation to units specified">Margins</label>
                                                (
                                                <label for="pxlMarginsActive" class="inline">Individual:</label>
                                                <input type="checkbox" id="pxlMarginsActive" onclick="checkGroupActive('pxlMarginsActive', 'pxlMarginsGroup', 'pxlMargins');">
                                                )
                                                <input type="number" step="any" id="pxlMargins" class="form-control" />
                                            </div>
                                            <div class="inline" id="pxlMarginsGroup">
                                                <div class="form-group form-inline">
                                                    <label for="pxlMarginsTop">&nbsp; Top:</label>
                                                    <input type="number" step="any" id="pxlMarginsTop" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlMarginsRight">&nbsp; Right:</label>
                                                    <input type="number" step="any" id="pxlMarginsRight" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlMarginsBottom">&nbsp; Bottom:</label>
                                                    <input type="number" step="any" id="pxlMarginsBottom" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlMarginsLeft">&nbsp; Left:</label>
                                                    <input type="number" step="any" id="pxlMarginsLeft" class="form-control pull-right" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="inline">Size</label>
                                                (
                                                <label for="pxlSizeActive" class="inline">Enable:</label>
                                                <input type="checkbox" id="pxlSizeActive" onclick="checkGroupActive('pxlSizeActive', 'pxlSizeGroup');" />
                                                )
                                            </div>
                                            <div class="inline" id="pxlSizeGroup">
                                                <div class="form-group form-inline">
                                                    <label for="pxlSizeWidth" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; Width:
                                                    </label>
                                                    <input type="number" step="any" id="pxlSizeWidth" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlSizeHeight" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; Height:
                                                    </label>
                                                    <input type="number" step="any" id="pxlSizeHeight" class="form-control pull-right" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="inline">Bounds</label>
                                                (
                                                <label for="pxlBoundsActive" class="inline">Enable:</label>
                                                <input type="checkbox" id="pxlBoundsActive" onclick="checkGroupActive('pxlBoundsActive', 'pxlBoundsGroup');" />
                                                )
                                            </div>
                                            <div class="inline" id="pxlBoundsGroup">
                                                <div class="form-group form-inline">
                                                    <label for="pxlBoundX" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; X:
                                                    </label>
                                                    <input type="number" step="any" id="pxlBoundX" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlBoundY" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; Y:
                                                    </label>
                                                    <input type="number" step="any" id="pxlBoundY" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlBoundWidth" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; Width:
                                                    </label>
                                                    <input type="number" step="any" id="pxlBoundWidth" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="pxlBoundHeight" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                        &nbsp; Height:
                                                    </label>
                                                    <input type="number" step="any" id="pxlBoundHeight" class="form-control pull-right" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr />

                                <fieldset>
                                    <legend>Printer Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="pPxlWidth" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                    Render Width
                                                </label>
                                                <input type="number" id="pPxlWidth" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pPxlRange" class="tip" data-toggle="tooltip" title="Comma-separated ranges">Page Range(s)</label>
                                                <input type="text" id="pPxlRange" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="pPxlHeight" class="tip" data-toggle="tooltip" title="In relation to units specified">
                                                    Render Height
                                                </label>
                                                <input type="number" id="pPxlHeight" class="form-control pull-right" />
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="pPxlTransparent">Ignore Transparency:</label>
                                                <input type="checkbox" id="pPxlTransparent" class="pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr />

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetPixelOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="serialContent" class="tab-pane col-md-8">
                <h3>Serial</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-toolbar">
                            <button type="button" class="btn btn-info" onclick="listSerialPorts();">List Ports</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" onclick="openSerialPort();">Open Port</button>
                                <button type="button" class="btn btn-warning" onclick="closeSerialPort();">Close Port</button>
                            </div>
                            <button type="button" class="btn btn-default" onclick="sendSerialData();">Send Command</button>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <fieldset>
                                    <legend>Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="serialPort">Port</label>
                                                <input type="text" id="serialPort" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialBaud">Baud Rate</label>
                                                <input type="number" id="serialBaud" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialData">Data Bits</label>
                                                <input type="number" id="serialData" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialStop">Stop Bits</label>
                                                <input type="number" id="serialStop" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialParity">Parity</label>
                                                <input type="text" id="serialParity" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialFlow">Flow Control</label>
                                                <input type="text" id="serialFlow" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="serialCmd">Data</label>
                                                <input type="text" id="serialCmd" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label>Data Type</label>
                                                <div class="pull-right">
                                                    <label>
                                                        <input type="radio" name="serialType" id="serialPlainRadio" value="PLAIN"/>
                                                        Plain
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="serialType" id="serialFileRadio" value="FILE"/>
                                                        File
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialWidth">Encoding</label>
                                                <input type="text" id="serialEncoding" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr/>

                                <fieldset>
                                    <legend>Response Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="serialStart">Start Bytes</label>
                                                <input type="text" id="serialStart" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialEnd">End Byte</label>
                                                <input type="text" id="serialEnd" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialWidth">Width</label>
                                                <input type="number" id="serialWidth" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialHeader">Include Header</label>
                                                <input type="checkbox" id="serialHeader" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="serialRespEncoding">Encoding</label>
                                                <input type="text" id="serialRespEncoding" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="serialNewline" class="inline">Wait for new line</label>
                                                <input type="checkbox" id="serialNewline" onclick="checkItemsDisabled('serialNewline', [ 'serialStart', 'serialEnd', 'serialWidth', 'serialHeader' ]);" />
                                            </div>
                                            <div class="form-group">
                                                <label class="inline">Length Bytes</label>
                                                (
                                                <label for="serialLengthActive" class="inline">Enable:</label>
                                                <input type="checkbox" id="serialLengthActive" onclick="checkGroupActive('serialLengthActive', 'serialLengthGroup');" />
                                                )
                                            </div>
                                            <div class="inline" id="serialLengthGroup">
                                                <div class="form-group form-inline">
                                                    <label for="serialLenIndex">&nbsp; Index:</label>
                                                    <input type="number" id="serialLenIndex" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="serialLenLength">&nbsp; Length:</label>
                                                    <input type="number" id="serialLenLength" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label>&nbsp; Endian:</label>
                                                    <div class="pull-right">
                                                        <label>
                                                            <input type="radio" name="serialLenEndian" id="serialLenEndianBig" value="BIG" />
                                                            Big
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="serialLenEndian" id="serialLenEndianLittle" value="LITTLE" />
                                                            Little
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="inline">CRC Bytes</label>
                                                (
                                                <label for="serialCrcActive" class="inline">Enable:</label>
                                                <input type="checkbox" id="serialCrcActive" onclick="checkGroupActive('serialCrcActive', 'serialCrcGroup');" />
                                                )
                                            </div>
                                            <div class="inline" id="serialCrcGroup">
                                                <div class="form-group form-inline">
                                                    <label for="serialCrcIndex">&nbsp; Index:</label>
                                                    <input type="number" id="serialCrcIndex" class="form-control pull-right" />
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="serialCrcLength">&nbsp; Length:</label>
                                                    <input type="number" id="serialCrcLength" class="form-control pull-right" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetSerialOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="socketContent" class="tab-pane col-md-8">
                <h3>Socket</h3>
                <p>Socket API is experimental; API subject to change.</p>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" onclick="openSocket();">Open Socket</button>
                                    <button type="button" class="btn btn-warning" onclick="closeSocket();">Close Socket</button>
                                </div>
                                <button type="button" class="btn btn-default" onclick="sendSocketData()">Send Data</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <fieldset>
                                    <legend>Options</legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="socketHost">Host</label>
                                                <input type="text" id="socketHost" class="form-control pull-right" />
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="socketPort">Port</label>
                                                <input type="number" id="socketPort" class="form-control pull-right" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label for="socketData">Data</label>
                                                <input type="text" id="socketData" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="usbContent" class="tab-pane col-md-8">
                <h3>USB</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="listUsbDevices();">List Devices</button>
                                    <button type="button" class="btn btn-info" onclick="listUsbDeviceInterfaces();">List Interfaces</button>
                                    <button type="button" class="btn btn-info" onclick="listUsbInterfaceEndpoints();">List Endpoints</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="checkUsbDevice()">Check Claimed</button>
                                    <button type="button" class="btn btn-success" onclick="claimUsbDevice()">Claim Device</button>
                                    <button type="button" class="btn btn-warning" onclick="releaseUsbDevice()">Release Device</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="sendUsbData()">Send Data</button>
                                    <button type="button" class="btn btn-default" onclick="readUsbData()">Read Data</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="openUsbStream()">Open Stream</button>
                                    <button type="button" class="btn btn-default" onclick="closeUsbStream()">Close Stream</button>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label id="usbRawRadio" class="btn btn-default active">
                                        <input type="radio" autocomplete="off" checked>
                                        Raw
                                    </label>
                                    <label id="usbWeightRadio" class="btn btn-default">
                                        <input type="radio" autocomplete="off">
                                        Weight
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="usbVendor">Vendor ID</label>
                                            <input type="text" id="usbVendor" class="form-control pull-right" onblur="formatHexInput('usbVendor')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbProduct">Product ID</label>
                                            <input type="text" id="usbProduct" class="form-control pull-right" onblur="formatHexInput('usbProduct')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbInterface">Device Interface</label>
                                            <input type="text" id="usbInterface" class="form-control pull-right" onblur="formatHexInput('usbInterface')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbEndpoint">Interface Endpoint</label>
                                            <input type="text" id="usbEndpoint" class="form-control pull-right" onblur="formatHexInput('usbEndpoint')" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="usbData">Send Data</label>
                                            <input type="text" id="usbData" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbResponse">Read size</label>
                                            <input type="text" id="usbResponse" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="usbStream" class="tip" data-toggle="tooltip" title="Streaming Only: In milliseconds">
                                                Stream Interval
                                            </label>
                                            <input type="text" id="usbStream" class="form-control pull-right" />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetUsbOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="hidContent" class="tab-pane col-md-8">
                <h3>HID</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="listHidDevices();">List Devices</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="checkHidDevice()">Check Claimed</button>
                                    <button type="button" class="btn btn-success" onclick="claimHidDevice()">Claim Device</button>
                                    <button type="button" class="btn btn-warning" onclick="releaseHidDevice()">Release Device</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="startHidListen()">Listen for Events</button>
                                    <button type="button" class="btn btn-default" onclick="stopHidListen()">Stop Listening</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="sendHidData()">Send Data</button>
                                    <button type="button" class="btn btn-default" onclick="readHidData()">Read Data</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="openHidStream()">Open Stream</button>
                                    <button type="button" class="btn btn-default" onclick="closeHidStream()">Close Stream</button>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label id="hidRawRadio" class="btn btn-default active">
                                        <input type="radio" autocomplete="off" checked>
                                        Raw
                                    </label>
                                    <label id="hidWeightRadio" class="btn btn-default">
                                        <input type="radio" autocomplete="off">
                                        Weight
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="hidVendor">Vendor ID</label>
                                            <input type="text" id="hidVendor" class="form-control pull-right" onblur="formatHexInput('hidVendor')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidProduct">Product ID</label>
                                            <input type="text" id="hidProduct" class="form-control pull-right" onblur="formatHexInput('hidProduct')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidUsagePage" class="tip" data-toggle="tooltip"
                                                   title="Optional: For devices that expose multiple endpoints">
                                                Usage Page
                                            </label>
                                            <input type="text" id="hidUsagePage" class="form-control pull-right" onblur="formatHexInput('hidUsagePage')" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidSerial" class="tip" data-toggle="tooltip"
                                                   title="Optional: For distinguishing between identical devices">
                                                Serial Number
                                            </label>
                                            <input type="text" id="hidSerial" class="form-control pull-right" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="hidData">Send Data</label>
                                            <input type="text" id="hidData" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidReport">Report Id</label>
                                            <input type="text" id="hidReport" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidResponse">Read size</label>
                                            <input type="text" id="hidResponse" class="form-control pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="hidStream" class="tip" data-toggle="tooltip" title="Streaming Only: In milliseconds">
                                                Stream Interval
                                            </label>
                                            <input type="text" id="hidStream" class="form-control pull-right" />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetHidOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="statusContent" class="tab-pane col-md-8">
                <h3>Printer Status</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="startPrintersListen()">All Printers</button>
                                    <button type="button" class="btn btn-success" onclick="startPrintersListen($('#configPrinter').text())">
                                        Current Printer
                                    </button>
                                    <button type="button" class="btn btn-default" onclick="getPrintersStatus()">Request Current Status</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning" onclick="stopPrintersListen()">Stop Listening</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <fieldset>
                                    <legend>Options</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-inline">
                                                <label class="tip" for="jobData" data-toggle="tooltip" title="Returns raw spool file content for printers configured to keep spooled documents (Windows only)">
                                                    Include Raw Job Data
                                                </label>
                                                <input type="checkbox" id="jobData" class="pull-right"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pull-right">
                                            <div class="form-group form-inline">
                                                <label class="tip" for="maxJobData" data-toggle="tooltip" title="Maximum size in bytes of spool file content to return (Windows only)">
                                                Raw Job Data Size
                                                </label>
                                                <input type="number" id="maxJobData" class="pull-right"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-inline">
                                        <label>Job Data Type</label>
                                        <div>
                                            <label>
                                                <input type="radio" name="jobDataRadio" id="jobFlavorPLN" value="plain" />
                                                Plain
                                            </label>
                                            <label>
                                                <input type="radio" name="jobDataRadio" id="jobFlavorB64" value="base64" />
                                                Base64
                                            </label>
                                            <label>
                                                <input type="radio" name="jobDataRadio" id="jobFlavorHEX" value="hex" />
                                                Hexadecimal
                                            </label>
                                        </div>
                                    </div>
                                    <hr />
                                    <legend>Event Log</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <pre id="printersLog"></pre>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger pull-right" onclick="clearPrintersLog();"><i class="fa fa-trash"></i> Clear</button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="fileContent" class="tab-pane col-md-8">
                <h3>Files</h3>
                <hr />

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <button type="button" class="btn btn-info" onclick="listFiles();">List Files</button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="readFile();">Read File</button>
                                    <button type="button" class="btn btn-success" onclick="writeFile();">Write File</button>
                                    <button type="button" class="btn btn-warning" onclick="deleteFile();">Delete File</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" onclick="startFileListen()">Listen for Folder Events</button>
                                    <button type="button" class="btn btn-default" onclick="stopFileListen()">Stop Listening</button>
                                </div>
                                <button type="button" class="btn btn-default" onclick="stopAllFileListeners();">Stop All Listeners</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 1em;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">Options</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fileLocation">
                                                File / Directory Path
                                            </label>
                                            <input type="text" id="fileLocation" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label for="fileData">Data To Write</label>
                                            <textarea id="fileData" rows="5" style="resize:vertical" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Data Type</label>
                                            <div>
                                                <label>
                                                    <input type="radio" name="fileFlavor" id="fileFlavorPLN" value="plain" />
                                                    Plain
                                                </label>
                                                <label>
                                                    <input type="radio" name="fileFlavor" id="fileFlavorB64" value="base64" />
                                                    Base64
                                                </label>
                                                <label>
                                                    <input type="radio" name="fileFlavor" id="fileFlavorURL" value="file" />
                                                    File
                                                </label>
                                                <label>
                                                    <input type="radio" name="fileFlavor" id="fileFlavorHEX" value="hex" />
                                                    Hexadecimal
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="includePattern" class="tip" data-toggle="tooltip" title="File pattern to match when listening for file events (e.g. *.txt)">
                                                Include File Pattern
                                            </label>
                                            <input type="text" id="includePattern" class="form-control pull-right" />
                                        </div>
                                        <div class="form-group">
                                            <label for="excludePattern" class="tip" data-toggle="tooltip" title="File pattern to ignore when listening for file events (e.g. *.tmp) ">
                                                Exclude File Pattern
                                            </label>
                                            <input type="text" id="excludePattern" class="form-control pull-right" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-inline">
                                            <label for="fileShared">
                                                Shared
                                            </label>
                                            <input type="checkbox" id="fileShared" class="pull-right" />
                                        </div>
                                        <div class="form-group form-inline">
                                            <label for="fileSandbox" data-toggle="tooltip">
                                                Sandbox
                                            </label>
                                            <input checked type="checkbox" id="fileSandbox" class="pull-right" />
                                        </div>
                                        <div class="form-group form-inline">
                                            <label for="fileAppend">
                                                Append Data
                                            </label>
                                            <input type="checkbox" id="fileAppend" class="pull-right" />
                                        </div>

                                        <div class="form-group form-inline">
                                            <label for="fileListenerData">
                                                Listener Data
                                            </label>
                                            <input type="checkbox" id="fileListenerData" class="pull-right" onclick="checkGroupActive('fileListenerData', 'fileTriggersGroup')" />
                                        </div>
                                        <div class="inline" id="fileTriggersGroup">
                                            <div class="form-group form-inline">
                                                <label>
                                                    Read direction
                                                </label>
                                                <div>
                                                    <label>
                                                        <input type="radio" name="fileDir" id="fileDirEnd" value="end" />
                                                        End
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="fileDir" id="fileDirStart" value="begin" />
                                                        Start
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label>
                                                    Truncate
                                                </label>
                                                <div>
                                                    <label>
                                                        <input type="radio" name="fileTruncate" id="fileTruncateLines" value="lines" />
                                                        Lines
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="fileTruncate" id="fileTruncateBytes" value="bytes" />
                                                        Bytes
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="fileLength">Truncate length</label>
                                                <input type="number" id="fileLength" class="form-control pull-right" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-danger pull-right" onclick="resetFileOptions();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="askFileModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askFile">File:</label>
                        <input type="text" id="askFile" class="form-control" value="C:\tmp\example-file.txt" />
                        <hr />
                        <p><span class="text-danger" style="font-weight:bold;"><span class="fa fa-warning"></span> WARNING:</span> This feature has been deprecated.  Please configure a local raw <code>FILE:</code> printer, or use <code>File IO</code></a> instead.  For more
                            information please see <a href="https://github.com/qzind/tray/issues/730">issue&nbsp;<code>#730</code>.</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintFile();">Set</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="askHostModal" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="askHost">Host:</label>
                        <input type="text" id="askHost" class="form-control" value="192.168.1.254" />
                    </div>
                    <div class="form-group">
                        <label for="askPort">Port:</label>
                        <input type="text" id="askPort" class="form-control" value="9100" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="setPrintHost();">Set</button>
                </div>
            </div>
        </div>
    </div>

</div>
</body>


<script>
    /// Authentication setup ///
    qz.security.setCertificatePromise(function(resolve, reject) {
        //Preferred method - from server
//        fetch("assets/signing/digital-certificate.txt", {cache: 'no-store', headers: {'Content-Type': 'text/plain'}})
//          .then(function(data) { data.ok ? resolve(data.text()) : reject(data.text()); });

        //Alternate method 1 - anonymous
//        resolve();  // remove this line in live environment

        //Alternate method 2 - direct
        resolve("-----BEGIN CERTIFICATE-----\n" +
        "MIIECzCCAvOgAwIBAgIUBpYZOYLxgUQC/c4d+nxoI1/NkS0wDQYJKoZIhvcNAQEL\n" +
                "BQAwgZQxCzAJBgNVBAYTAklEMRMwEQYDVQQIDApZb2d5YWthcnRhMRMwEQYDVQQH\n" +
                "DApZb2d5YWthcnRhMRQwEgYDVQQKDAtUZWtub2R1a2FzaTEMMAoGA1UECwwDUE9T\n" +
                "MQwwCgYDVQQDDANBUFAxKTAnBgkqhkiG9w0BCQEWGmZyZW5raWhlcmxhbWJhbmdA\n" +
                "Z21haWwuY29tMB4XDTIzMTAwNjEyMjcyN1oXDTMzMTAwMzEyMjcyN1owgZQxCzAJ\n" +
                "BgNVBAYTAklEMRMwEQYDVQQIDApZb2d5YWthcnRhMRMwEQYDVQQHDApZb2d5YWth\n" +
                "cnRhMRQwEgYDVQQKDAtUZWtub2R1a2FzaTEMMAoGA1UECwwDUE9TMQwwCgYDVQQD\n" +
                "DANBUFAxKTAnBgkqhkiG9w0BCQEWGmZyZW5raWhlcmxhbWJhbmdAZ21haWwuY29t\n" +
                "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAryhW5I5046ciIRgzPaeY\n" +
                "Z5EFjVPV2SBuR/8shdHjmnnrC/+FNmmCu03XrjW9c5w2epivPdAFYZ/v26paS/LP\n" +
                "Fbq4frQ68q8IMxCWDl2fQJXmMgya4Lm1NvQP6nfEPkf92fqMLGbrvH7b/H4GqHse\n" +
                "dS+d/rTjAb6vsQJ7GtsZXe0lbk7J8mEe16H5poBvfDmGU0so0bMqtCDDPsKgKY1+\n" +
                "DDYv1HzI3+Q/KPRb02GmwkDzU5q9KtX+21EIo90B5Oj29ttd7jiirSb56731rThG\n" +
                "Buk6d3WEbjvQ3wzOJqIBTD0LOAc3CtKdhbuhlPIxFIN5Zu1WGjscXfODtUuouEXx\n" +
                "1QIDAQABo1MwUTAdBgNVHQ4EFgQUdjXto+KOZvmN/mBsdpu55SkZdM8wHwYDVR0j\n" +
                "BBgwFoAUdjXto+KOZvmN/mBsdpu55SkZdM8wDwYDVR0TAQH/BAUwAwEB/zANBgkq\n" +
                "hkiG9w0BAQsFAAOCAQEAIkH+2k2K41HEwY/BemwOyTtpQHpcTnu9T2oGn35D4kRN\n" +
                "LnmR5+f7cKtHYg2+xzjALzUV2alqoliikrqKmRFHbGQVsONdnQ8ukNnOGFm5ELgq\n" +
                "MgbyDmn789mu8b5tx81mjWrEmNpjS3Ewlztg+t1OpJfzhUXMFSgzPm6MbGY8FEIV\n" +
                "v3hSDKD8b/snmvmgMOhHBc9rxufDT6WavxAHxUIs2JpNgvTw0sWQQl0VDftNowOr\n" +
                "t4PCiUlWYWZpALVAZYwa0LLLRAwHkdYVtFMBjjYgOtV3kJxJo09vunEvNzZFUFeW\n" +
                "YFja6+ZFVyY/9Nz4PoceW55Rn/0nn2CwHOD/Z5QrTw==\n" +
                    "-----END CERTIFICATE-----\n");
    });

//     qz.security.setSignatureAlgorithm("SHA512"); // Since 2.1
//     qz.security.setSignaturePromise(function(toSign) {
//         return function(resolve, reject) {
//             //Preferred method - from server
// //            fetch("/secure/url/for/sign-message?request=" + toSign, {cache: 'no-store', headers: {'Content-Type': 'text/plain'}})
// //              .then(function(data) { data.ok ? resolve(data.text()) : reject(data.text()); });

//             //Alternate method - unsigned
//             resolve(); // remove this line in live environment
//         };
//     });


    /// Connection ///
    function launchQZ() {
        if (!qz.websocket.isActive()) {
            window.location.assign("qz:launch");
            //Retry 5 times, pausing 1 second between each attempt
            startConnection({ retries: 5, delay: 1 });
        }
    }

    function startConnection(config) {
        var host = $('#connectionHost').val().trim();
        var usingSecure = $("#connectionUsingSecure").prop('checked');

        // Connect to a print-server instance, if specified
        if (host != "" && host != 'localhost') {
            if (config) {
                config.host = host;
                config.usingSecure = usingSecure;
            } else {
                config = { host: host, usingSecure: usingSecure };
            }
        }

        if (!qz.websocket.isActive()) {
            updateState('Waiting', 'default');

            qz.websocket.connect(config).then(function() {
                updateState('Active', 'success');
                findVersion();
            }).catch(handleConnectionError);
        } else {
            displayMessage('An active connection with QZ already exists.', 'alert-warning');
        }
    }

    function endConnection() {
        if (qz.websocket.isActive()) {
            qz.websocket.disconnect().then(function() {
                updateState('Inactive', 'default');
            }).catch(handleConnectionError);
        } else {
            displayMessage('No active connection with QZ exists.', 'alert-warning');
        }
    }


    function listNetworkDevices() {
        var listItems = function(obj) {
            var html = '';
            var labels = { mac: 'MAC', ip: 'IP', up: 'Up', ip4: 'IPv4', ip6: 'IPv6', primary: 'Primary' };

            Object.keys(labels).forEach(function(key) {
                if (!obj.hasOwnProperty(key)) { return; }
                if (key !== 'ip' && obj[key] == obj['ip']) { return; }

                var value = obj[key];
                if (key === 'mac') { value = obj[key].match(/.{1,2}/g).join(':'); }
                if (typeof obj[key] === 'object') { value = value.join(', '); }

                html += '<li><strong>' + labels[key] + ':</strong> <code>' + value + '</code></li>';
            });

            return html;
        };

        qz.networking.devices().then(function(data) {
            var list = '';

            for(var i = 0; i < data.length; i++) {
                var info = data[i];

                if (i == 0) {
                    list += "<li>" +
                        "   <strong>Hostname:</strong> <code>" + info.hostname + "</code>" +
                        "</li>" +
                        "<li>" +
                        "   <strong>Username:</strong> <code>" + info.username + "</code>" +
                        "</li>";
                }
                list += "<li>" +
                    "   <strong>Interface:</strong> <code>" + (info.name || "UNKNOWN") + (info.id ? "</code> (<code>" + info.id + "</code>)" : "</code>") +
                    "   <ul>" + listItems(info) + "</ul>" +
                    "</li>";
            }

            pinMessage("<strong>Network details:</strong><ul>" + list + "</ul>");
        }).catch(displayError);
    }

    /// Detection ///
    function findPrinter(query, set, radio) {
        $("#printerSearch").val(query);
        qz.printers.find(query).then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
            if(radio) {
                var input = document.querySelector("input[value='" + radio + "']");
                if(input) {
                    input.checked = true;
                    $(input.parentElement).fadeOut(300).fadeIn(500);
                }
            }
        }).catch(displayError);
    }

    function findDefaultPrinter(set) {
        qz.printers.getDefault().then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findPrinters() {
        qz.printers.find().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; " + data[i] + "<br/>";
            }

            displayMessage("<strong>Available printers:</strong><br/>" + list, null, 15000);
        }).catch(displayError);
    }

    function detailPrinters() {
        qz.printers.details().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "<li>" + (data[i].default ? "* " : "") + data[i].name + "<ul>" +
                    "<li><strong>Driver:</strong> " + data[i].driver + "</li>" +
                    "<li><strong>Density:</strong> " + data[i].density + "dpi</li>" +
                    "<li><strong>Connection:</strong> " + data[i].connection + "</li>" +
                    (data[i].trays ? "<li><strong>Trays:</strong> " + data[i].trays + "</li>" : "") +
                    "</ul></li>";
            }

            pinMessage("<strong>Printer details:</strong><br/><ul>" + list + "</ul>");
        }).catch(displayError);
    }


    /// Raw Printers ///
    function printCommand() {
        var config = getUpdatedConfig();
        var lang = getUpdatedOptions().language; //print options not used with this flavor, just check language requested

        var printData;
        switch(lang) {
            case 'EPL':
                printData = [
                    '\nN\n',
                    'q812\n', //  q=width in dots - check printer dpi
                    'Q1218,26\n', // Q=height in dots - check printer dpi
                    'B5,26,0,1A,3,7,152,B,"1234"\n',
                    'A310,26,0,3,1,1,N,"SKU 00000 MFG 0000"\n',
                    'A310,56,0,3,1,1,N,"TEST PRINT SUCCESSFUL"\n',
                    'A310,86,0,3,1,1,N,"FROM SAMPLE.HTML"\n',
                    'A310,116,0,3,1,1,N,"PRINTED WITH QZ ' + qzVersion + '"\n',
                    '\nP1,1\n'
                ];
                break;
            case 'ZPL':
                printData = [
                    '^XA\n',
                    '^FO50,50^ADN,36,20^FDPRINTED WITH QZ ' + qzVersion + '\n',
                    '^FS\n',
                    '^XZ\n'
                ];
                break;
            case 'ESCPOS':
                printData = [
                    //defaults to 'type: raw', 'format: command', and 'flavor: plain'
                    { data: '\nPRINTED WITH QZ ' + qzVersion + '.\n\n\n\n\n\n' }
                ];
                break;
            case 'EPCL':
                printData = buildEPCL();
                break;
            case 'EVOLIS':
                printData = [
                    '\x1BPps;0\x0D',   // Enable raw/disable driver printer parameter supervision
                    '\x1BPwr;0\x0D',   // Landscape (zero degree) orientation
                    '\x1BWcb;k;0\x0D', // Clear card memory

                    '\x1BSs\x0D',      // Start of sequence
                    { type: 'raw', format: 'image', data: 'assets/img/fade-test.png', options: { language: "EVOLIS", precision: 128 } },
                    '\x1BWt;50;60;0;30;Printed using QZ Tray ' + qzVersion + '\x0D', // 50,60 = coordinates; 0 = arial font
                    '\x1BSe\x0D'       // End of sequence
                ];
                break;
            case 'SBPL':
                printData = [
                    '\x1BA',
                    '\x1BH0100\x1BV0100\x1BXSPRINTED WITH QZ ' + qzVersion,
                    '\x1BQ1\x1BZ'
                ];
                break;
            case 'PGL':
                printData = [
                    '~CREATE;QZQRCODE;288\n',
                    'SCALE;DOT;300;300\n',
                    'ALPHA\n',
                    'POINT;50;100;16;9;*Printed using QZ Tray*\n',
                    'STOP\n',
                    'BARCODE\n',
                    'QRCODE;XD10;80;30\n',
                    '*https://qz.io*\n',
                    'STOP\n',
                    'END\n',
                    '~EXECUTE;QZQRCODE;1\n',
                    '~NORMAL\n'
                ];
                break;
            default:
                displayError("Sample is missing plain commands for " + lang + " printer language");
                return;
        }

        qz.print(config, printData).catch(displayError);
    }

    function buildEPCL() {
        var printData = [];
        $.merge(printData, convertEPCL('+RIB 4'));     // Monochrome ribbon
        $.merge(printData, convertEPCL('F'));          // Clear monochrome print buffer
        $.merge(printData, convertEPCL('+C 8'));       // Adjust monochrome intensity
        $.merge(printData, convertEPCL('&R'));         // Reset magnetic encoder
        $.merge(printData, convertEPCL('&CDEW 0 0'));  // Set R/W encoder to ISO default
        $.merge(printData, convertEPCL('&CDER 0 0'));  // Set R/W encoder to ISO default
        $.merge(printData, convertEPCL('&SVM 0'));     // Disable magnetic encoding verifications
        $.merge(printData, convertEPCL('T 80 600 0 1 0 45 1 QZ INDUSTRIES'));   // Write text buffer
        $.merge(printData, convertEPCL('&B 1 123456^INDUSTRIES/QZ^789012'));    // Write mag strip buffer
        $.merge(printData, convertEPCL('&E*'));        // Encode magnetic data
        $.merge(printData, convertEPCL('I 10'));       // Print card (10 returns to print ready pos.)
        $.merge(printData, convertEPCL('MO'));         // Move card to output hopper

        return printData;
    }

    /**
     * EPCL helper function that appends a single line of EPCL data, taking into account
     * special EPCL NUL characters, data length, escape character and carriage return
     */
    function convertEPCL(data) {
        if (data == null || data.length == 0) {
            console.warn('Empty EPCL data, skipping');
        }

        // Data length for this command, in 2 character Hex (base 16) format
        var len = (data.length + 2).toString(16);
        if (len.length < 2) { len = '0' + len; }

        //defaults to 'type: raw' and 'format: command'
        return [
            { flavor: 'hex', data: 'x00x00x00' },  // Append 3 NULs
            { flavor: 'hex', data: 'x' + len },    // Append our command length, in base16
            { flavor: 'plain', data: data },       // Append our command
            { flavor: 'plain', data: '\r' }        // Append carriage return
        ];
    }

    /* Sample EPL Only */
    function printBase64() {
        var config = getUpdatedConfig();
        //print options not used with this flavor

        // Send base64 encoded characters/raw commands to qz using data type 'base64'.
        // This will automatically convert provided base64 encoded text into text/ascii/bytes, etc.
        // This example is for EPL and contains an embedded image.
        // Please adapt to your printer language.

        //noinspection SpellCheckingInspection
        var printData = [
            {
                type: 'raw', format: 'command', flavor: 'base64',
                data: 'Ck4KcTYwOQpRMjAzLDI2CkI1LDI2LDAsMUEsMyw3LDE1MixCLCIxMjM0IgpBMzEwLDI2LDAsMywx' +
                    'LDEsTiwiU0tVIDAwMDAwIE1GRyAwMDAwIgpBMzEwLDU2LDAsMywxLDEsTiwiUVogUFJJTlQgQVBQ' +
                    'TEVUIgpBMzEwLDg2LDAsMywxLDEsTiwiVEVTVCBQUklOVCBTVUNDRVNTRlVMIgpBMzEwLDExNiww' +
                    'LDMsMSwxLE4sIkZST00gU0FNUExFLkhUTUwiCkEzMTAsMTQ2LDAsMywxLDEsTiwiUVpJTkRVU1RS' +
                    'SUVTLkNPTSIKR1cxNTAsMzAwLDMyLDEyOCz/////////6SSSX///////////////////////////' +
                    '//////////6UlUqX////////////////////////////////////8kqkpKP/////////////////' +
                    '//////////////////6JUpJSVf//////////////////////////////////9KpKVVU+////////' +
                    '//////////////////////////8KSSlJJf5/////////////////////////////////9KUqpVU/' +
                    '/7////////////////////////////////9KqUkokf//P///////////////////////////////' +
                    '+VKUqpZP//+P///////////////////////////////ElKUlSf///9f/////////////////////' +
                    '////////+ipSkqin////y/////////////////////////////+lVUpUlX/////r////////////' +
                    '/////////////////qlJKUql/////+n////////////////////////////BFKVKUl//////8v//' +
                    '/////////////////////////zVSlKUp///////0f//////////////////////////wiSlSUpf/' +
                    '//////q///////////////////////////KqlJUpV///////+R//////////////////////////' +
                    '4UlKSpSX///////9T/////////6L///////////////BKlKpSqP///////1X////////0qg/23/V' +
                    'VVVVVVf//8CSlJKklf///////kv///////+pS0/JP8AAAAAAB///wFSlSSpV///////+pf//////' +
                    '/pUoq+qfwAAAAAAH//+AClSqpUT///////9S///////8pJUlkr+AAAAAAA///4AFJSSSUv//////' +
                    '/yl///////KVUpTUv8AAAAAAH///gBKSqlVU////////lX//////6UkqoiU/wAAAAAA///+ABKpJ' +
                    'Uko////////JH//////UpIiqlJ/AAAAAAD///wACkSUpJX///////6q//////6pVVSqiv4AAAAAA' +
                    'f///AAJVVIqpP///////pI//////pSVtSSq/wAAAAAD///8AAJSlVJVf///////Sp/////8Sq//U' +
                    'qL/ttttoAP///wAAUpVSpJ///////+pT/////qkn//UlH/////AB////AABKUSpSX///////5Sn/' +
                    '///+lJ//+pS/////4AP///8AABKUkpVP///////ylP////1Kv//+qr/////AA////4AAKVVJUl//' +
                    '/////+lKf////KS///8kv////8AH////gAAKSSpJR///////9Kq////9Kv///5Kf////gAf///+A' +
                    'AAUlUqov///////1JT////lS////qn////8AD////4AABKpKSqf///////Skj///+kr////JH///' +
                    '/wAf////wAACkqUlK///////8pKv///ypf///9V////+AD/////AAAFKUVSj///////wqlP///JT' +
                    '////yR////wAP////8AAAFKqkpv///////JSlf//9Sv////U/////AB/////4AAAVIpKRf//////' +
                    '+ElV///pS////8of///4AP/////gAAASZVKr///////4qkj///Sn////0v////AA//////AAABUS' +
                    'VJH///////glJn//8pP////KH///8AH/////+AAACtUlVf//////+ClRP//qV////9K////gA///' +
                    '///4AAACEpJK///////8BSqf/+lX////yr///8AD//////wAAAVUqVH///////gUlU//5Rf////R' +
                    'P///gAf//////gAAApKqTP//////8AVSV//pU////6qf//+AD//////+AAAAqkki//////8AEpVL' +
                    '/+qP////1L///wAP//////4AAACSVVB/////+AFUpKX/9KP////Sv//+AB///////AAAAEqSgH//' +
                    '//+ACkpSUv/lV////6k///4AP//////+AAAAUlSgf////gAJKRUpf/ST////1J///AA///////4A' +
                    'AAAVJVB////gAtVFUpV/8lX///+Vf//4AH///////gAAABKSSD///wASSVVJSR/1Vf///8kf//gA' +
                    '///////+AAAABVUof//4AElUpKqqv/SL////1L//8AD///////4AAAABJJQ//8AFVJKVKSSP+qj/' +
                    '///Kv//gAf///////gAAAAKSpT/+ACkqSlKUkqf5Rf///6S//+AD///////+AAAAAKqpP/ABJKVS' +
                    'klKqU/xUf///qp//wAP///////4AAAAAkko+gASVKUlVKlKX/VK///9Sf/+AB////////gAAAACp' +
                    'UrgAKqVKVJKSlKf+Sl///0kf/4AP///////+AAAAABSVIAFJUlKqSUpKV/0pX//8qr//AA//////' +
                    '//8AAAAACklACSopKSVUqVKX/qpH//okv/4AH////////gAAAAAVVKBUpUqUkkpKSk//SSv/xVK/' +
                    '/AAAAAAD////AAAAAAJKWSUpVKVVUqVSp/+qqH9SlR/8AAAAAAH///4AAAAABSUklJSSlJJKUkpf' +
                    '/8klQFSo//gAAAAAA////wAAAAABVKqlUkqlSqkqqU//6pUqkkof8AAAAAAB/r//AAAAAAElEpSK' +
                    'qSlSSpJKL//pUqpVKr/wAAAAAAP8v/8AAAAAAJLKUqkkpSqkqSVf//yUkpKSv+AAAAAAAfqf/wAA' +
                    'AAAAVClKVVUoklUqqp///UpKVVS/wAAAAAAD+S//AAAAAAAlpSkkkpVKkpKSX///JVKTpR+AAAAA' +
                    'AAH9X/8AAAAAABRUpVJUqqSpSUlf///SSk/Sv4AAAAAAA/y//wAAAAAAFSVUlSUkUkpUqr////VS' +
                    'v9S/AAAAAAAB/3//AAAAAAAFUkpSlJMqqUpJP////13/pT////////////8AAAAAAAEpJSlSqUkk' +
                    'pVS////////Un////////////wAAAAAABJVSlSpUqpUpJX///////8q/////////////gAAAAAAC' +
                    'pSqkkpKSUpSSP///////5L////////////+AAAAAAACSkVVKSklKpVV///////+SX///////////' +
                    '/4AAAAAAAFSqJKlSqqiVSX///////9U/////////////gAAAAAAASpVSlSkklVJU////////yr//' +
                    '//////////+AAAAAAAAkpJSklKpKSUp////////kn////////////4AAAAAAABJSqlKqkqUqVf//' +
                    '/////5K/////////////gAAAAAAACpUlKpJKUqlI////////1L////////////+AAAAAAAAFSVKS' +
                    'SqkpFKX////////SX////////////4AAAAAAAAiklKlSSpTKKv///////9U/////////////wAAA' +
                    'AAAABSpSlSqlSiVJ////////pV/////////////AAAAAAAAVUpSkklSlUqX////////Uv///////' +
                    '/////8AAAAAAAAkqUpVJJSqpVf///////8pf////////////4AAAAAAAFJKUpKqUpJUT////////' +
                    '4r/////////////wAAAAAAAKqVKVKUqSSVX///////+Uv/////////////gAAAAAAASUlKSkpKql' +
                    'S////////+qf/////////////AAAAAAAEkpKUlUpJJCn////////iH///////////wAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH/4B+A8AH/AAAAA' +
                    'AAAAAAAAAAAAAA//AAfwD4H4HwAAf/4H4DwB//gAAAAAAAAAAAAAAAAAD/+AB/APgfgfAAB//wfw' +
                    'PAf/+AAAAAAAAAAAAAgAAAAP/8AH8AfB+D4AAH//B/g8D//4AAAAAAAAAAAADwAAAA//4A/4B8H4' +
                    'PgAAfB+H+DwP4HgAAAAAAAAAAAAPwAAAD4fgD/gHw/w+AAB8D4f8PB+AGAAAAAAAAAAAAA/wAAAP' +
                    'g+Af/AfD/D4AAHwPh/48HwAAAAAAAAAAAAAAB/4AAA+D4B98A+P8PAAAfA+Hvjw+AAAAAAAAAAAA' +
                    'AAAB/4AAD4PgH3wD4/x8AAB8H4e/PD4AAAAAAAAAAAAAAAB/8AAPh8A+PgPn/nwAAH//B5+8Pg/4' +
                    'AH/j/x/4/8f+AA/8AA//wD4+A+eefAAAf/4Hj7w+D/gAf+P/H/j/x/4AA/wAD/+APj4B5554AAB/' +
                    '/AeP/D4P+AB/4/8f+P/H/gAD/AAP/wB8HwH3nvgAAH/wB4f8Pw/4AH/j/x/4/8f+AA/8AA//AH//' +
                    'Af+f+AAAfAAHg/wfAPgAAAAAAAAAAAAAf/AAD5+A//+B/w/4AAB8AAeD/B+A+AAAAAAAAAAAAAH/' +
                    'gAAPj8D//4D/D/AAAHwAB4H8H+D4AAAAAAAAAAAAB/4AAA+H4P//gP8P8AAAfAAHgPwP//gAAAAA' +
                    'AAAAAAAP8AAAD4fh+A/A/w/wAAB8AAeA/Af/+AAAAAAAAAAAAA/AAAAPg/HwB8B+B+AAAHwAB4B8' +
                    'Af/4AAAAAAAAAAAADwAAAA+B+fAHwH4H4AAAfAAHgHwAf4AAAAAAAAAAAAAIAAAAD4H/8Afgfgfg' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' +
                    'AAAAAAAAAAAAAAAAAAAAAAAAClAxLDEK'
            }
        ];

        qz.print(config, printData).catch(displayError);
    }

    /* Sample ZPL Only */
    function printXML() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions();

        var printData = [
            { type: 'raw', format: 'command', flavor: 'xml', data: 'assets/zpl_sample.xml', options: opts }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printHex() {
        var config = getUpdatedConfig();
        var lang = getUpdatedOptions().language; //print options not used with this flavor, just check language requested

        var printData;
        switch(lang) {
            case 'EPL':
                //defaults to 'type: raw' and 'format: command'
                printData = [
                    { flavor: 'hex', data: '0a4e0a713831320a51313231382c32363b207120616e6420' },
                    { flavor: 'hex', data: '512076616c7565732065646974656420746f207265666c65' },
                    { flavor: 'hex', data: '63742034783620696e63682073697a652061742032303320' },
                    { flavor: 'hex', data: '6470690a42352c32362c302c31412c332c372c3135322c42' },
                    { flavor: 'hex', data: '2c2231323334220a413331302c32362c302c332c312c312c' },
                    { flavor: 'hex', data: '4e2c22534b55203030303030204d46472030303030220a41' },
                    { flavor: 'hex', data: '3331302c35362c302c332c312c312c4e2c22515a2d547261' },
                    { flavor: 'hex', data: '79204a617661204170706c69636174696f6e220a41333130' },
                    { flavor: 'hex', data: '2c38362c302c332c312c312c4e2c2254455354205052494e' },
                    { flavor: 'hex', data: '54205355434345535346554c220a413331302c3131362c30' },
                    { flavor: 'hex', data: '2c332c312c312c4e2c2246524f4d2053414d504c452e4854' },
                    { flavor: 'hex', data: '4d4c220a413331302c3134362c302c332c312c312c4e2c22' },
                    { flavor: 'hex', data: '5553494e4720484558220a50312c310a' }
                ];
                break;
            case 'ZPL':
                printData = [
                    { flavor: 'hex', data: '5e58410d0a5e464f35302c35300d0a5e41444e2c33362c3' },
                    { flavor: 'hex', data: '2300d0a5e46445052494e544544205749544820515a2054' },
                    { flavor: 'hex', data: '5241590d0a5e46445553494e472068657820434f4d4d414' },
                    { flavor: 'hex', data: 'e44530d0a5e46530d0a5e585a' }
                ];
                break;
            case 'ESCPOS':
                printData = [
                    { flavor: 'hex', data: '0d0a5052494e544544205749544820515a20545241590d0a0d0a' },
                    { flavor: 'hex', data: '5553494e472068657820434f4d4d414e44530d0a0d0a0d0a0d0a' }
                ];
                break;
            default:
                displayError("Sample is missing hex commands for " + lang + " printer language");
                break;
        }


        qz.print(config, printData).catch(displayError);
    }

    function printRawImage() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions();

        var printData;
        switch(opts.language) {
            case 'EPL':
                printData = [
                    '\nN\n',
                    { type: 'raw', format: 'image', flavor: 'file', data: 'assets/img/image_sample_bw.png', options: opts },
                    '\nP1,1\n'
                ];
                break;
            case 'ZPL':
                printData = [
                    '^XA\n',
                    { type: 'raw', format: 'image', flavor: 'file', data: 'assets/img/image_sample_bw.png', options: opts },
                    '^XZ\n'
                ];
                break;
            case 'ESCPOS':
                printData = [
                    //defaults to 'flavor: file'
                    { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: opts },
                ];
                break;
            case 'SBPL':
                printData = [
                    '\x1BA',
                    '\x1BH0100\x1BV0100',
                    { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: opts },
                    '\x1BQ1\x1BZ'
                ];
                break;
            case 'PGL':
                // Printronix must reference logos by ID
                opts.logoId = 'LOGO-QZ-1';
                opts.igpDots = false;

                printData = [
                    // Printronix logo should appear before form declarations
                    { type: 'raw', format: 'image', data: 'assets/img/image_sample_bw.png', options: opts },
                    "~CREATE;FORM-1;432\n",
                    "LOGO\n",
                    // Position of the logo on the form y=1, x=1
                    "1;1;" + opts.logoId + "\n",
                    "STOP\n",
                    "END\n",
                    "~PAPER;CUT 0;PAUSE 0;TEAR 0\n",
                    "~EXECUTE;FORM-1;1\n",
                    "~NORMAL\n",
                    "~DELETE FORM;FORM-1\n",
                    // Printronix must explicitly delete logos which have been uploaded
                    "~DELETE LOGO;" + opts.logoId + "\n"
                ];
                break;
            default:
                displayError("Sample is missing image commands for " + lang + " printer language");
                return;
        }

        qz.print(config, printData).catch(displayError);
    }

    function printRawPDF() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions();

        var printData;
        switch(opts.language) {
            case 'EPL':
                printData = [
                    '\nN\n',
                    'q812\n',
                    'Q1218,26\n',
                    { type: 'raw', format: 'pdf', flavor: 'file', data: 'assets/pdf_sample.pdf', options: opts },
                    '\nP1,1\n'
                ];
                break;
            case 'ZPL':
                printData = [
                    '^XA\n',
                    { type: 'raw', format: 'pdf', flavor: 'file', data: 'assets/pdf_sample.pdf', options: opts },
                    '^XZ\n'
                ];
                break;
            case 'ESCPOS':
                printData = [
                    { type: 'raw', format: 'pdf', flavor: 'file', data: 'assets/pdf_sample.pdf', options: opts }
                ];
                break;
            default:
                displayError("Cannot print PDFs using this printer language");
                break;
        }

        qz.print(config, printData).catch(displayError);
    }

    function printRawHTML() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions();

        var printData;
        switch(opts.language) {
            case 'EPL':
                printData = [
                    '\nN\n',
                    'q812\n',
                    'Q1218,26\n',
                    { type: 'raw', format: 'html', flavor: 'file', data: 'https://qz.io/about/', options: opts },
                    '\nP1,1\n'
                ];
                break;
            case 'ZPL':
                printData = [
                    '^XA\n',
                    { type: 'raw', format: 'html', flavor: 'file', data: 'https://qz.io/about/', options: opts },
                    '^XZ\n'
                ];
                break;
            case 'ESCPOS':
                printData = [
                    { type: 'raw', format: 'html', flavor: 'file', data: 'https://qz.io/about/', options: opts }
                ];
                break;
            default:
                displayError("Cannot print HTML using this printer language");
                break;
        }

        qz.print(config, printData).catch(displayError);
    }

    function printFile(file) {
        var config = getUpdatedConfig();
        //print options not used with this flavor

        var printData = [
            { type: 'raw', format: 'command', flavor: 'file', data: 'print/assets/' + file }
        ];

        qz.print(config, printData).catch(displayError);
    }


    /// Pixel Printers ///
    function printHTML() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions(true);

        var printData = [
            {
                type: 'pixel',
                format: 'html',
                flavor: 'plain',
                data: '<html>' +
                    '<body>' +
                    '  <table style="font-family: monospace; width: 100%">' +
                    '    <tr>' +
                    '      <td>' +
                    '        <h2>* QZ Tray HTML Sample Print *</h2>' +
                    '        <span style="color: #D00;">Version:</span> ' + qzVersion + '<br/>' +
                    '        <span style="color: #D00;">Source:</span> https://qz.io/' +
                    '      </td>' +
                    '      <td align="right">' +
                    '        <img src="' + getPath() + '/assets/img/image_sample.png" />' +
                    '      </td>' +
                    '    </tr>' +
                    '  </table>' +
                    '</body>' +
                    '</html>',
                options: opts
            }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printPDF() {
        var config = getUpdatedConfig();
        var opts = getUpdatedOptions(true);

        var printData = [
            { type: 'pixel', format: 'pdf', flavor: 'file', data: 'assets/pdf_sample.pdf', options: opts }
        ];

        qz.print(config, printData).catch(displayError);
    }

    function printImage() {
        var config = getUpdatedConfig();
        //print options not used with this flavor

        var printData = [
            { type: 'pixel', format: 'image', flavor: 'file', data: 'assets/img/image_sample.png' }
            //also valid, as format and flavor will default to proper values:
//             { type: 'pixel', data: 'assets/img/image_sample.png' }
        ];

        qz.print(config, printData).catch(displayError);
    }


    /// Serial ///
    function listSerialPorts() {
        qz.serial.findPorts().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; <code>" + data[i] + "</code>" + serialButton(["serialPort"], [data[i]]) + "<br/>";
            }

            displayMessage("<strong>Available serial ports:</strong><br/>" + list);
        }).catch(displayError);
    }

    function openSerialPort() {
        var options = getSerialOptions();

        qz.serial.openPort($("#serialPort").val(), options).then(function() {
            displayMessage("Serial port opened");
        }).catch(displayError);
    }

    function sendSerialData() {
        var options = getSerialOptions();

        var serialData = {
            type: $("input[name='serialType']:checked").val(),
            data: $("#serialCmd").val()
        };

        var fromHex = function(m, s1) {
            return String.fromCharCode(parseInt(s1, 16));
        };

        //allow some escape characters (newlines, tabs, hex/unicode)
        serialData.data = serialData.data.replace(/\\n/g, "\n").replace(/\\r/g, "\r").replace(/\\t/g, "\t")
            .replace(/\\x([0-9A-Za-z]{2})/g, fromHex).replace(/\\u([0-9A-Za-z]{4})/g, fromHex);

        qz.serial.sendData($("#serialPort").val(), serialData, options).catch(displayError);
    }

    function closeSerialPort() {
        qz.serial.closePort($("#serialPort").val()).then(function() {
            displayMessage("Serial port closed");
        }).catch(displayError);
    }


    // Socket //
    function openSocket() {
        qz.socket.open($("#socketHost").val(), $("#socketPort").val()).then(function() {
            displayMessage("Socket opened");
        }).catch(displayError);
    }

    function sendSocketData() {
        qz.socket.sendData($("#socketHost").val(), $("#socketPort").val(), $("#socketData").val()).catch(displayError);
    }

    function closeSocket() {
        qz.socket.close($("#socketHost").val(), $("#socketPort").val()).then(function() {
            displayMessage("Socket closed");
        }).catch(displayError);
    }


    /// USB ///
    function listUsbDevices() {
        qz.usb.listDevices(true).then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                var device = data[i];
                if (device.hub) { list += "USB Hub"; }

                list += "<p>" +
                    "   VendorID: <code>0x" + device.vendorId + "</code>" +
                    usbButton(["usbVendor", "usbProduct"], [device.vendorId, device.productId]) + "<br/>" +
                    "   ProductID: <code>0x" + device.productId + "</code><br/>";

                if (device.manufacturer) { list += "   Manufacturer: <code>" + device.manufacturer + "</code><br/>"; }
                if (device.product) { list += "   Product: <code>" + device.product + "</code><br/>"; }

                list += "</p><hr/>";
            }

            pinMessage("<strong>Available usb devices:</strong><br/>" + list);
        }).catch(displayError);
    }

    function listUsbDeviceInterfaces() {
        qz.usb.listInterfaces({
                                  vendorId: $("#usbVendor").val(),
                                  productId: $("#usbProduct").val()
                              })
            .then(function(data) {
                var list = '';
                for(var i = 0; i < data.length; i++) {
                    list += "&nbsp; <code>0x" + data[i] + "</code>" + usbButton(["usbInterface"], [data[i]]) + "<br/>";
                }

                displayMessage("<strong>Available device interfaces:</strong><br/>" + list);
            }).catch(displayError);
    }

    function listUsbInterfaceEndpoints() {
        qz.usb.listEndpoints({
                                 vendorId: $("#usbVendor").val(),
                                 productId: $("#usbProduct").val(),
                                 interface: $("#usbInterface").val()
                             })
            .then(function(data) {
                var list = '';
                for(var i = 0; i < data.length; i++) {
                    list += "&nbsp; <code>0x" + data[i] + "</code>" + usbButton(["usbEndpoint"], [data[i]]) + "<br/>";
                }

                displayMessage("<strong>Available interface endpoints:</strong><br/>" + list);
            }).catch(displayError);
    }

    function claimUsbDevice() {
        qz.usb.claimDevice({
                               vendorId: $("#usbVendor").val(),
                               productId: $("#usbProduct").val(),
                               interface: $("#usbInterface").val()
                           })
            .then(function() {
                displayMessage("USB Device claimed");
            }).catch(displayError);
    }

    function checkUsbDevice() {
        qz.hid.isClaimed({
                             vendorId: $("#usbVendor").val(),
                             productId: $("#usbProduct").val()
                         })
            .then(function(claimed) {
                displayMessage("USB Device is " + (claimed ? "" : "not ") + "claimed");
            }).catch(displayError);
    }

    function sendUsbData() {
        qz.usb.sendData({
                            vendorId: $("#usbVendor").val(),
                            productId: $("#usbProduct").val(),
                            endpoint: $("#usbEndpoint").val(),
                            data: $("#usbData").val()
                        })
            .catch(displayError);
    }

    function readUsbData() {
        qz.usb.readData({
                            vendorId: $("#usbVendor").val(),
                            productId: $("#usbProduct").val(),
                            endpoint: $("#usbEndpoint").val(),
                            responseSize: $("#usbResponse").val()
                        })
            .then(function(data) {
                displayMessage("<strong>Response:</strong> " + (window.readingWeight ? readScaleData(data) : data) + "<br/>");
            }).catch(displayError);
    }

    function openUsbStream() {
        qz.usb.openStream({
                              vendorId: $("#usbVendor").val(),
                              productId: $("#usbProduct").val(),
                              endpoint: $("#usbEndpoint").val(),
                              responseSize: $("#usbResponse").val(),
                              interval: $("#usbStream").val()
                          })
            .then(function() {
                pinMessage("Waiting on device", '' + $("#usbVendor").val() + $("#usbProduct").val());
            }).catch(displayError);
    }

    function closeUsbStream() {
        qz.usb.closeStream({
                               vendorId: $("#usbVendor").val(),
                               productId: $("#usbProduct").val(),
                               endpoint: $("#usbEndpoint").val()
                           })
            .then(function() {
                $('#' + $("#usbVendor").val() + $("#usbProduct").val()).attr('id', '').html("Stream closed");
            }).catch(displayError);
    }

    function releaseUsbDevice() {
        qz.usb.releaseDevice({
                                 vendorId: $("#usbVendor").val(),
                                 productId: $("#usbProduct").val()
                             })
            .then(function() {
                displayMessage("USB Device released");
            }).catch(displayError);
    }


    /// HID ///
    function listHidDevices() {
        qz.hid.listDevices().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                var device = data[i];

                list += "<p>" +
                    "   VendorID: <code>0x" + device.vendorId + "</code>" +
                    usbButton(["hidVendor", "hidProduct", "hidUsagePage", "hidSerial"],
                              [device.vendorId, device.productId, device.usagePage, device.serial]) + "<br/>" +
                    "   ProductID: <code>0x" + device.productId + "</code><br/>" +
                    (device.usagePage ? "   Usage Page: <code>0x" + device.usagePage + "</code><br/>" : "") +
                    (device.serial ? "   Serial: <code>" + device.serial + "</code><br/>" : "") +
                    (device.manufacturer ? "   Manufacturer: <code>" + device.manufacturer + "</code><br/>" : "") +
                    (device.product ? "   Product: <code>" + device.product + "</code><br/>" : "") +
                    "</p><hr/>";
            }

            pinMessage("<strong>Available hid devices:</strong><br/>" + list);
        }).catch(displayError);
    }

    function startHidListen() {
        qz.hid.startListening().then(function() {
            displayMessage("Started listening for HID events");
        }).catch(displayError);
    }

    function stopHidListen() {
        qz.hid.stopListening().then(function() {
            displayMessage("Stopped listening for HID events");
        }).catch(displayError);
    }

    function claimHidDevice() {
        qz.hid.claimDevice({
                               vendorId: $("#hidVendor").val(),
                               productId: $("#hidProduct").val(),
                               usagePage: $("#hidUsagePage").val(),
                               serial: $("#hidSerial").val()
                           })
            .then(function() {
                displayMessage("HID Device claimed");
            }).catch(displayError);
    }

    function checkHidDevice() {
        qz.hid.isClaimed({
                             vendorId: $("#hidVendor").val(),
                             productId: $("#hidProduct").val(),
                             usagePage: $("#hidUsagePage").val(),
                             serial: $("#hidSerial").val()
                         })
            .then(function(claimed) {
                displayMessage("HID Device is " + (claimed ? "" : "not ") + "claimed");
            }).catch(displayError);
    }

    function sendHidData() {
        qz.hid.sendData({
                            vendorId: $("#hidVendor").val(),
                            productId: $("#hidProduct").val(),
                            usagePage: $("#hidUsagePage").val(),
                            serial: $("#hidSerial").val(),
                            data: $("#hidData").val(),
                            endpoint: $("#hidReport").val()
                        })
            .catch(displayError);
    }

    function readHidData() {
        qz.hid.readData({
                            vendorId: $("#hidVendor").val(),
                            productId: $("#hidProduct").val(),
                            usagePage: $("#hidUsagePage").val(),
                            serial: $("#hidSerial").val(),
                            responseSize: $("#hidResponse").val()
                        })
            .then(function(data) {
                displayMessage("<strong>Response:</strong> " + (window.readingWeight ? readScaleData(data) : data) + "<br/>");
            }).catch(displayError);
    }

    function openHidStream() {
        qz.hid.openStream({
                              vendorId: $("#hidVendor").val(),
                              productId: $("#hidProduct").val(),
                              usagePage: $("#hidUsagePage").val(),
                              serial: $("#hidSerial").val(),
                              responseSize: $("#hidResponse").val(),
                              interval: $("#hidStream").val()
                          })
            .then(function() {
                pinMessage("Waiting on device", '' + $("#hidVendor").val() + $("#hidProduct").val());
            }).catch(displayError);
    }

    function closeHidStream() {
        qz.hid.closeStream({
                               vendorId: $("#hidVendor").val(),
                               productId: $("#hidProduct").val(),
                               usagePage: $("#hidUsagePage").val(),
                               serial: $("#hidSerial").val()
                           })
            .then(function() {
                $('#' + $("#hidVendor").val() + $("#hidProduct").val()).attr('id', '').html("Stream closed");
            }).catch(displayError);
    }

    function releaseHidDevice() {
        qz.hid.releaseDevice({
                                 vendorId: $("#hidVendor").val(),
                                 productId: $("#hidProduct").val(),
                                 usagePage: $("#hidUsagePage").val(),
                                 serial: $("#hidSerial").val()
                             })
            .then(function() {
                displayMessage("HID Device released");
            }).catch(displayError);
    }


    /// Status ///
    function startPrintersListen(printerName) {
        var jobData = $("#jobData").prop("checked");
        var jobDataFlavor = $('input[name="jobDataRadio"]:checked').val();
        var maxJobData = $("#maxJobData").val();
        if (printerName === "NONE") {
            return displayMessage("Please search for a valid printer first", "alert-warning");
        }
        qz.printers.stopListening().then(function() {
            clearPrintersLog();
            var params = {
                jobData: jobData,
                maxJobData: maxJobData,
                flavor: jobDataFlavor
            };
            return qz.printers.startListening(printerName, params);
        }).then(function() {
            displayMessage("Started listening for " + (printerName ? printerName : "all") + " printer events");
        }).catch(displayError);
    }

    function getPrintersStatus() {
        qz.printers.getStatus().then(function() {
            displayMessage("Requesting all printer statuses for listened printers");
        }).catch(displayError);
    }

    function stopPrintersListen() {
        qz.printers.stopListening().then(function() {
            displayMessage("Stopped listening for printer events");
            clearPrintersLog();
        }).catch(displayError);
    }


    /// File ///
    function listFiles() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked")
        };

        qz.file.list($("#fileLocation").val(), params).then(function(data) {
            var files = "";
            for(var n = 0; n < data.length; n++) {
                files += data[n] + "\n";
            }
            displayMessage("File listing <strong><code>" + $("#fileLocation").val() + "</code></strong><pre>" + files + "</pre>", null, 15000);
        }).catch(displayError);
    }

    function readFile() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked"),
            flavor: $("input[name='fileFlavor']:checked").val()
        };

        qz.file.read($("#fileLocation").val(), params).then(function(data) {
            displayMessage("Contents of <strong><code>" + $("#fileLocation").val() + "</code></strong><pre>" + data + "</pre>", null, 15000);
        }).catch(displayError);
    }

    function writeFile() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked"),
            append: $("#fileAppend").prop('checked'),
            flavor: $("input[name='fileFlavor']:checked").val(),
            data: $("#fileData").val()
        };

        qz.file.write($("#fileLocation").val(), params).then(function() {
            displayMessage("File <strong><code>" + $("#fileLocation").val() + "</code></strong> written successfully");
        }).catch(displayError);
    }

    function deleteFile() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked")
        };

        qz.file.remove($("#fileLocation").val(), params).then(function() {
            displayMessage("File <strong><code>" + $("#fileLocation").val() + "</code></strong> deleted");
        }).catch(displayError);
    }

    function startFileListen() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked"),
            include: $("#includePattern").val() == "" ? [] : $("#includePattern").val(),
            exclude: $("#excludePattern").val() == "" ? [] : $("#excludePattern").val(),
            ignoreCase: true,
            listener: {}
        };

        if (isChecked($("#fileListenerData"))) {
            params.listener.reverse = !!$("#fileDirEnd").prop("checked"); //else fileStartRadio checked

            var len = $("#fileLength").val();
            if (!!$("#fileTruncateLines").prop("checked")) { //else fileTruncateBytes checked
                params.listener.lines = len;
            } else {
                params.listener.bytes = len;
            }
        }

        qz.file.startListening($("#fileLocation").val(), params).then(function() {
            displayMessage("Started listening for <strong><code>" + ($("#fileLocation").val() || "./") + "</code></strong> events");
        }).catch(displayError);
    }

    function stopFileListen() {
        var params = {
            sandbox: $("#fileSandbox").prop("checked"),
            shared: $("#fileShared").prop("checked")
        };

        qz.file.stopListening($("#fileLocation").val(), params).then(function() {
            displayMessage("Stopped listening for <strong><code>" + ($("#fileLocation").val() || "./") + "</code></strong> events");
        }).catch(displayError);
    }

    function stopAllFileListeners() {
        qz.file.stopListening().then(function() {
            displayMessage("Stopped listening for <strong>all</strong> file events");
        }).catch(displayError);
    }


    /// Resets ///
    function resetGeneralOptions() {
        //connection
        $("#connectionHost").val('localhost');

        var secureOpt = $("#connectionUsingSecure");
        if (location.protocol !== 'https:') {
            secureOpt.prop('disabled', true);
            secureOpt.prop('checked', false);
        } else {
            secureOpt.prop('disabled', false);
        }
    }

    function resetRawOptions() {
        //config
        $("#rawSpoolSize").val(1);
        $("#rawEncoding").val("");
        $("#rawSpoolEnd").val("");
        $("#rawForceRaw").prop('checked', false);
        $("#rawCopies").val(1);

        //printer
        $("#pLangEPL").prop('checked', true);
        $("#pX").val('0');
        $("#pY").val('0');
        $("#pDotDensity").val('single');
        $("#pXml").val('v7:Image');
        $("#pRawWidth").val('480');
        $("#pRawHeight").val('');
    }

    function resetPixelOptions() {
        //config
        $("#pxlColorType").val("color");
        $("#pxlCopies").val(1);
        $("#pxlDuplex").val("");
        $("#pxlInterpolation").val("");
        $("#pxlJobName").val("");
        $("#pxlLegacy").prop('checked', false);
        $("#pxlOrientation").val("");
        $("#pxlPaperThickness").val("");
        $("#pxlPrinterTray").val("");
        $("#pxlRasterize").prop('checked', false);
        $("#pxlRotation").val(0);
        $("#pxlSpoolSize").val("");
        $("#pxlScale").prop('checked', true);
        $("#pxlUnitsIN").prop('checked', true);

        $("#pxlDensity").val('').css('display', '');
        $("#pxlCrossDensity").val('');
        $("#pxlFeedDensity").val('');
        $("#pxlDensityAsymm").prop('checked', false);
        $("#pxlDensityGroup").css('display', 'none');

        $("#pxlMargins").val(0).css('display', '');
        $("#pxlMarginsTop").val(0);
        $("#pxlMarginsRight").val(0);
        $("#pxlMarginsBottom").val(0);
        $("#pxlMarginsLeft").val(0);
        $("#pxlMarginsActive").prop('checked', false);
        $("#pxlMarginsGroup").css('display', 'none');

        $("#pxlSizeWidth").val('');
        $("#pxlSizeHeight").val('');
        $("#pxlSizeActive").prop('checked', false);
        $("#pxlSizeGroup").css('display', 'none');

        $("#pxlBoundX").val(0);
        $("#pxlBoundY").val(0);
        $("#pxlBoundWidth").val('');
        $("#pxlBoundHeight").val('');
        $("#pxlBoundsActive").prop('checked', false);
        $("#pxlBoundsGroup").css('display', 'none');

        //printer
        $("#pPxlWidth").val('');
        $("#pPxlHeight").val('');
        $("#pPxlRange").val('');
        $("#pPxlTransparent").prop('checked', false);

        //connection
        $("#connectionGroup").css('display', 'none');

        $("#pxlContent").find(".dirty").removeClass("dirty");
    }

    function resetSerialOptions() {
        $("#serialPort").val('');
        $("#serialBaud").val(9600);
        $("#serialData").val(8);
        $("#serialStop").val(1);
        $("#serialParity").val('NONE');
        $("#serialFlow").val('NONE');

        $("#serialCmd").val('');
        $("#serialPlainRadio").prop('checked', true);
        $("#serialEncoding").val("UTF-8");

        $("#serialStart").val('');
        $("#serialEnd").val('');
        $("#serialWidth").val('');
        $("#serialHeader").prop('checked', false);
        $("#serialRespEncoding").val('UTF-8');
        $("#serialLenIndex").val('0');
        $("#serialLenLength").val('1');
        $("#serialLenEndianBig").prop('checked', true);
        $("#serialLengthGroup").css('display', 'none');
        $("#serialCrcIndex").val('0');
        $("#serialCrcLength").val('1');
        $("#serialCrcGroup").css('display', 'none');

        // M/T PS60 - 9600, 7, 1, EVEN, NONE
    }

    function resetUsbOptions() {
        $("#usbVendor").val('');
        $("#usbProduct").val('');

        $("#usbInterface").val('');
        $("#usbEndpoint").val('');
        $("#usbData").val('');
        $("#usbResponse").val(8);
        $("#usbStream").val(100);

        // M/T PS60 - V:0x0EB8 P:0xF000, I:0x0 E:0x81
        // Dymo S100 - V:0x0922 P:0x8009, I:0x0 E:0x82
    }

    // Copy raw radio-button text to command buttons
    function updateRawButtons() {
        var lang = $("input[name='pLanguage']:checked").parent('label').text().trim();

        var appendLang = function(element, lang) {
            var text = $(element).html();
            var label = text.split("(")[0];
            $(element).html(label + " (<strong>" + lang + "</strong>)");
        }

        $("#rawCommandsGroup").children()
            .each(function() {
                appendLang(this, lang);
            });

        $("#rawRasterGroup").children()
            .each(function() {
                appendLang(this, lang);
            });
    }

    function resetHidOptions() {
        $("#hidVendor").val('');
        $("#hidProduct").val('');
        $("#hidUsagePage").val('');
        $("#hidSerial").val('');

        $("#hidInterface").val('');
        $("#hidEndpoint").val('');
        $("#hidData").val('');
        $("#hidReport").val('');
        $("#hidResponse").val(8);
        $("#hidStream").val(100);
    }

    function clearPrintersLog() {
        $("#printersLog").html("");
    }

    function resetFileOptions() {
        $("#fileLocation").val('');
        $("#fileData").val('');
        $("#fileFlavorPLN").prop('checked', true);
        $("#fileShared").prop('checked', true);
        $("#fileSandbox").prop('checked', true);
        $("#fileAppend").prop('checked', false);

        $("#fileListenerData").prop('checked', true);
        $("#fileDirEnd").prop('checked', true);
        $("#fileTruncateLines").prop('checked', true);
        $("#fileLength").val('10');
    }

    function resetPrinterStatusOptions() {
        $("#jobData").prop('checked', false);
        $("#maxJobData").val('');
        $("#jobFlavorPLN").prop('checked', true);
    }


    /// Page load ///
    $(document).ready(function() {
        window.readingWeight = false;

        resetGeneralOptions();
        resetRawOptions();
        resetPixelOptions();
        resetSerialOptions();
        resetUsbOptions();
        resetHidOptions();
        resetFileOptions();
        resetPrinterStatusOptions();
        updateRawButtons();

        startConnection();

        $("#printerSearch").on('keyup', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                findPrinter($('#printerSearch').val(), true);
                return false;
            }
        });

        $("#fileButton").on('change', function(e) {
            if (this.files && this.files[0]) {
                $("#fileLocation").val(this.files[0]['name']);
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
            if (window.readingWeight) {
                $("#usbWeightRadio").click();
                $("#hidWeightRadio").click();
            } else {
                $("#usbRawRadio").click();
                $("#hidRawRadio").click();
            }
        });

        if (location.hash) {
            $(".nav-tabs a[href='"+ location.hash +"']").tab('show');
        }
        $(".nav-tabs a").on("click", function(e) {
            location.hash = this.hash;
        });

        $("#usbRawRadio").click(function() { window.readingWeight = false; });
        $("#usbWeightRadio").click(function() { window.readingWeight = true; });
        $("#hidRawRadio").click(function() { window.readingWeight = false; });
        $("#hidWeightRadio").click(function() { window.readingWeight = true; });

        $("[data-toggle='tooltip']").tooltip();
    });

    qz.websocket.setClosedCallbacks(function(evt) {
        updateState('Inactive', 'default');
        console.log(evt);

        if (evt.reason) {
            displayMessage("<strong>Connection closed:</strong> " + evt.reason, 'alert-warning');
        }
    });

    qz.websocket.setErrorCallbacks(handleConnectionError);

    qz.serial.setSerialCallbacks(function(streamEvent) {
        if (streamEvent.type !== 'ERROR') {
            console.log('Serial', streamEvent.portName, 'received output', streamEvent.output);
            displayMessage("Received output from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.output + "</em>");
        } else {
            console.log(streamEvent.exception);
            displayMessage("Received an error from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.exception + "</em>", 'alert-error');
        }
    });

    qz.socket.setSocketCallbacks(function(socketEvent) {
        if (socketEvent.type !== 'ERROR') {
            console.log('Socket', socketEvent.host, socketEvent.port, 'received response', socketEvent.response);
            displayMessage("Received output from network socket [" + socketEvent.host + ":" + socketEvent.port + "]: <em>" + socketEvent.response + "</em>");
        } else {
            console.log(socketEvent.exception);
            displayMessage("Received error from network socket [" + socketEvent.host + ":" + socketEvent.port + "]: <em>" + socketEvent.exception + "</em>", 'alert-error');
        }
    });

    qz.usb.setUsbCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) != '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) != '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type !== 'ERROR') {
            if (window.readingWeight) {
                $pin.html("<strong>Weight:</strong> " + readScaleData(streamEvent.output));
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else {
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    qz.hid.setHidCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) != '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) != '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type === 'RECEIVE') {
            if (window.readingWeight) {
                var weight = readScaleData(streamEvent.output);
                if (weight) {
                    $pin.html("<strong>Weight:</strong> " + weight);
                }
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else if (streamEvent.type === 'ACTION') {
            displayMessage("<strong>Device status changed:</strong> " + "[v:" + vendor + " p:" + product + "] - " + streamEvent.actionType);
        } else { //ERROR type
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    qz.printers.setPrinterCallbacks(function(streamEvent) {
        addPrintersLog(streamEvent);
    });

    qz.file.setFileCallbacks(function(streamEvent) {
        if (streamEvent.type !== 'ERROR') {
            var text = "<h5>File IO Event</h5>" +
                "<strong>File:</strong> <code>" + streamEvent.file + "</code><br/>" +
                "<strong>Event:</strong><code>" + streamEvent.eventType + "</code><br/>";

            if (streamEvent.fileData) {
                text += "<strong>Data:</strong><br/><pre>" + streamEvent.fileData.replace(/\r?\n/g, "<br/>") + "</pre>";
            }

            displayMessage(text);
        } else {
            displayError("<strong>Error:</strong> " + streamEvent.message);
        }
    });

    var qzVersion = 0;
    function findVersion() {
        qz.api.getVersion().then(function(data) {
            $("#qz-version").html(data);
            qzVersion = data;
        }).catch(displayError);
    }

    $("#askFileModal").on("shown.bs.modal", function() {
        $("#askFile").focus().select();
    });
    $("#askHostModal").on("shown.bs.modal", function() {
        $("#askHost").focus().select();
    });

    //make dirty when changed
    $("input").add("select").on('change', function() {
        $(this).addClass("dirty");
    });


    /// Helpers ///
    function handleConnectionError(err) {
        updateState('Error', 'danger');

        if (err.target != undefined) {
            if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                displayError("Connection to QZ Tray was closed");
            } else {
                displayError("A connection error occurred, check log for details");
                console.error(err);
            }
        } else {
            displayError(err);
        }
    }

    function displayError(err) {
        console.error(err);
        displayMessage(err, 'alert-danger');
    }

    function displayMessage(msg, css, time) {
        if (css == undefined) { css = 'alert-info'; }

        var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, time ? time : 5000);

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
            .css('max-height', '20em').css('overflow', 'auto')
            .attr('id', timeout).attr('role', 'alert');
        alert.html("<button type='button' class='close' data-dismiss='alert'>&times;</button>" + msg);

        $("#qz-alert").append(alert);
    }

    //checkId = toggle checkbox, groupId = group/element to show, toggleId = group/element to hide
    function checkGroupActive(checkId, groupId, toggleId) {
        var checkBox = $("#"+ checkId);
        var useVisibility = false;
        var invisible = false;
        if(typeof checkBox.prop("checked") === 'undefined') {
            // if we're not dealing with a checkbox, rely blindly on visibility instead
            useVisibility = true;
            invisible = ($("#"+ groupId).css('display') == 'none');
            if(invisible) {
                checkBox.addClass("active");
            } else {
                checkBox.removeClass('active');
            }
        }
        if (isChecked(checkBox) || (useVisibility && invisible)) {
            $("#"+ groupId).css('display', '');
            if (toggleId) { $("#"+ toggleId).css('display', 'none'); }
        } else {
            $("#"+ groupId).css('display', 'none');
            if (toggleId) { $("#"+ toggleId).css('display', ''); }
        }
    }

    //checkId = toggle checkbox, itemsArray = elements to disable
    function checkItemsDisabled(checkId, itemsArray) {
        var disabled = isChecked($("#"+ checkId));
        for(var index in itemsArray) {
            $("#"+ itemsArray[index]).prop( "disabled", disabled);
        }
    }

    function addPrintersLog(streamEvent) {
        var msg;
        if (streamEvent.eventType == "JOB_DATA") {
            var jobData;
            var dataLevel;
            if(!streamEvent.data) {
                // Most commonly a permissions issue reading C:\Windows\system32\spool\PRINTERS\<jobId>
                // A custom spool location can be set using HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Print\Printers\DefaultSpoolDirectory
                jobData = "&lt;No data received, this may be a permissions issue or the printer may not be configured to retain documents.&gt;";
                dataLevel = "FATAL";
            } else {
                // Only show the first 64 characters (for display purposes)
                var DISPLAY_LEN = 64;
                jobData = streamEvent.data.substring(0, DISPLAY_LEN) + (streamEvent.data.length > DISPLAY_LEN ? "..." : "");
                dataLevel = "INFO";
            }
            var icon = '<span class="fa fa-file-o"></span>&nbsp;';
            msg = '<p class="' + dataLevel + '" text-nowrap">' + icon + new Date().toString() + ": JOB DATA: " + jobData + "</p>";

        } else {
            var icon = '<span class="fa ' + (streamEvent.eventType == 'JOB' ? 'fa-exchange' : 'fa-print') + '"></span>&nbsp;';
            msg = '<p class="' + (streamEvent.severity || "") + ' text-nowrap">' + icon + new Date().toString() + ": " + streamEvent.message + "</p>";
        }
        var $log = $("#printersLog");
        $log.html($log.html() + msg);
    }

    function pinMessage(msg, id, css) {
        if (css == undefined) { css = 'alert-info'; }

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
            .css('max-height', '20em').css('overflow', 'auto').attr('role', 'alert')
            .html("<button type='button' class='close' data-dismiss='alert'>&times;</button>");

        var text = $("<div/>").html(msg);
        if (id != undefined) { text.attr('id', id); }

        alert.append(text);

        $("#qz-pin").append(alert);
    }

    function updateState(text, css) {
        $("#qz-status").html(text);
        $("#qz-connection").removeClass().addClass('panel panel-' + css);

        if (text === "Inactive" || text === "Error") {
            $("#launch").show();
        } else {
            $("#launch").hide();
        }
    }

    function getPath() {
        var path = window.location.href;
        return path.substring(0, path.lastIndexOf("/"));
    }

    function isChecked(checkElm, ifClean) {
        if (!checkElm.hasClass("dirty")) {
            if (ifClean !== undefined) {
                var lbl = checkElm.siblings("label").text();
                displayMessage("Forced " + lbl + " " + ifClean + ".", 'alert-warning');

                return ifClean;
            }
        }

        return checkElm.prop("checked");
    }

    function includedValue(element, value) {
        if (value != null) {
            return value;
        } else if (element.hasClass("dirty")) {
            return element.val();
        } else {
            return undefined;
        }
    }

    function usbButton(ids, data) {
        var click = "";
        for(var i = 0; i < ids.length; i++) {
            var $id = "$('#" + ids[i] + "')";
            click += $id + ".val('" + (data[i] ? data[i] : "") + "');" + $id + ".blur();" + $id + ".fadeOut(300).fadeIn(500);";
        }
        return '<button class="btn btn-default btn-xs" onclick="' + click + '" data-dismiss="alert">Use This</button>';
    }

    function serialButton(serialPort, data) {
        var click = "";
        for(var i = 0; i < serialPort.length; i++) {
            click += "$('#" + serialPort[i] + "').val('" + data[i] + "');$('#" + serialPort[i] + "').fadeOut(300).fadeIn(500);";
        }
        return '<button class="btn btn-default btn-xs" onclick="' + click + '" data-dismiss="alert">Use This</button>';
    }

    function formatHexInput(inputId) {
        var $input = $('#' + inputId);
        var val = $input.val();

        if (val.length > 0 && val.substring(0, 2) != '0x') {
            val = '0x' + val;
        }

        $input.val(val.toLowerCase());
    }

    /** Attempts to parse scale reading from USB raw output */
    function readScaleData(data) {
        // Filter erroneous data
        if (data.length < 4 || data.slice(2, 8).join('') == "000000000000") {
            return null;
        }

        // Get status
        var status = parseInt(data[1], 16);
        switch(status) {
            case 1: // fault
            case 5: // underweight
            case 6: // overweight
            case 7: // calibrate
            case 8: // re-zero
                status = 'Error';
                break;
            case 3: // busy
                status = 'Busy';
                break;
            case 2: // stable at zero
            case 4: // stable non-zero
            default:
                status = 'Stable';
        }

        // Get precision
        var precision = parseInt(data[3], 16);
        precision = precision ^ -256; //unsigned to signed

        // xor on 0 causes issues
        if (precision == -256) { precision = 0; }

        // Get units
        var units = parseInt(data[2], 16);
        switch(units) {
            case 2:
                units = 'g';
                break;
            case 3:
                units = 'kg';
                break;
            case 11:
                units = 'oz';
                break;
            case 12:
            default:
                units = 'lbs';
        }

        // Get weight
        data.splice(0, 4);
        data.reverse();
        var weight = parseInt(data.join(''), 16);

        weight *= Math.pow(10, precision);
        weight = weight.toFixed(Math.abs(precision));

        return weight + units + ' - ' + status;
    }


    /// QZ Config ///
    var cfg = null;
    function getUpdatedConfig(cleanConditions) {
        if (cfg == null) {
            cfg = qz.configs.create(null);
        }

        updateConfig(cleanConditions || {});
        return cfg
    }

    function updateConfig(cleanConditions) {
        var pxlSize = null;
        if (isChecked($("#pxlSizeActive"), cleanConditions['pxlSizeActive']) && (($("#pxlSizeWidth").val() !== '') || ($("#pxlSizeHeight").val() !== ''))) {
            pxlSize = {
                width: $("#pxlSizeWidth").val(),
                height: $("#pxlSizeHeight").val()
            };
        }

        var pxlBounds = null;
        if (isChecked($("#pxlBoundsActive"), cleanConditions['pxlBoundsActive'])) {
            pxlBounds = {
                x: $("#pxlBoundX").val(),
                y: $("#pxlBoundY").val(),
                width: $("#pxlBoundWidth").val(),
                height: $("#pxlBoundHeight").val()
            };
        }

        var pxlDensity = includedValue($("#pxlDensity"));
        if (isChecked($("#pxlDensityAsymm"), cleanConditions['pxlDensityAsymm'])) {
            pxlDensity = {
                cross: $("#pxlCrossDensity").val(),
                feed: $("#pxlFeedDensity").val()
            };
        }

        var pxlMargins = includedValue($("#pxlMargins"));
        if (isChecked($("#pxlMarginsActive"), cleanConditions['pxlMarginsActive'])) {
            pxlMargins = {
                top: $("#pxlMarginsTop").val(),
                right: $("#pxlMarginsRight").val(),
                bottom: $("#pxlMarginsBottom").val(),
                left: $("#pxlMarginsLeft").val()
            };
        }

        var copies = 1;
        var spoolSize = null;
        var jobName = null;
        if ($("#rawTab").hasClass("active")) {
            copies = includedValue($("#rawCopies"));
            spoolSize = includedValue($("#rawSpoolSize"));
            jobName = includedValue($("#rawJobName"));
        } else {
            copies = includedValue($("#pxlCopies"));
            spoolSize = includedValue($("#pxlSpoolSize"));
            jobName = includedValue($("#pxlJobName"));
        }

        cfg.reconfigure({
                            forceRaw: includedValue($("#rawForceRaw"), isChecked($("#rawForceRaw"), cleanConditions['rawForceRaw'])),
                            encoding: includedValue($("#rawEncoding")),
                            spool: { size: spoolSize, end: includedValue($("#rawSpoolEnd")) },

                            bounds: pxlBounds,
                            colorType: includedValue($("#pxlColorType")),
                            copies: copies,
                            density: pxlDensity,
                            duplex: includedValue($("#pxlDuplex")),
                            interpolation: includedValue($("#pxlInterpolation")),
                            jobName: jobName,
                            margins: pxlMargins,
                            orientation: includedValue($("#pxlOrientation")),
                            paperThickness: includedValue($("#pxlPaperThickness")),
                            printerTray: includedValue($("#pxlPrinterTray")),
                            rasterize: includedValue($("#pxlRasterize"), isChecked($("#pxlRasterize"), cleanConditions['pxlRasterize'])),
                            rotation: includedValue($("#pxlRotation")),
                            scaleContent: includedValue($("#pxlScale"), isChecked($("#pxlScale"), cleanConditions['pxlScale'])),
                            size: pxlSize,
                            units: includedValue($("input[name='pxlUnits']:checked"))
                        });
    }

    function getUpdatedOptions(onlyPixel) {
        if (onlyPixel) {
            return {
                pageWidth: $("#pPxlWidth").val(),
                pageHeight: $("#pPxlHeight").val(),
                pageRanges: $("#pPxlRange").val(),
                ignoreTransparency: $("#pPxlTransparent").prop('checked')
            };
        } else {
            return {
                language: $("input[name='pLanguage']:checked").val(),
                x: $("#pX").val(),
                y: $("#pY").val(),
                dotDensity: $("#pDotDensity").val(),
                xmlTag: $("#pXml").val(),
                pageWidth: $("#pRawWidth").val(),
                pageHeight: $("#pRawHeight").val()
            };
        }
    }

    function getSerialOptions() {
        var options = {
            baudRate: $("#serialBaud").val(),
            dataBits: $("#serialData").val(),
            stopBits: $("#serialStop").val(),
            parity: $("#serialParity").val(),
            flowControl: $("#serialFlow").val(),
            encoding: $("#serialEncoding").val() || null,
            rx: {
                start: $("#serialStart").val(),
                end: $("#serialEnd").val() || null,
                width: $("#serialWidth").val() || null,
                untilNewline: $("#serialNewline").prop('checked'),
                lengthBytes: null,
                crcBytes: null,
                includeHeader: $("#serialHeader").prop('checked'),
                encoding: $("#serialRespEncoding").val()
            }
        };
        if (isChecked($("#serialLengthActive"))) {
            options.rx.lengthBytes = {
                index: $("#serialLenIndex").val(),
                length: $("#serialLenLength").val(),
                endian: $("input[name='serialLenEndian']:checked").val()
            };
        }
        if (isChecked($("#serialCrcActive"))) {
            options.rx.crcBytes = {
                index: $("#serialCrcIndex").val(),
                length: $("#serialCrcLength").val()
            };
        }

        return options;
    }

    function setPrintFile() {
        setPrinter({ file: $("#askFile").val() });
        $("#askFileModal").modal('hide');
    }

    function setPrintHost() {
        setPrinter({ host: $("#askHost").val(), port: $("#askPort").val() });
        $("#askHostModal").modal('hide');
    }

    function setPrinter(printer) {
        var cf = getUpdatedConfig();
        cf.setPrinter(printer);

        if (printer && typeof printer === 'object' && printer.name == undefined) {
            var shown;
            if (printer.file != undefined) {
                shown = "<em>FILE:</em> " + printer.file;
            }
            if (printer.host != undefined) {
                shown = "<em>HOST:</em> " + printer.host + ":" + printer.port;
            }

            $("#configPrinter").html(shown);
        } else {
            if (printer && printer.name != undefined) {
                printer = printer.name;
            }

            if (printer == undefined) {
                printer = 'NONE';
            }
            $("#configPrinter").html(printer);
        }
    }
</script>

</html>

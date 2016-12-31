<!DOCTYPE html>
<html>
    <head>
        <title><?php print h($this->title); ?></title>
<?php
    require(dirname(__FILE__) . "/../views/_headers.php");
?>
        <link href="/assets/styles/backend/backend.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
        </style>
        <?php
            require(dirname(__FILE__) . "/../views/_scripts.php");
        ?>
        <script src="https://cdn.ckeditor.com/4.6.1/standard-all/ckeditor.js"></script>
        <script src="/assets/javascript/backend/backend.js"></script>
        <script>
        	$(function() {
        		document.querySelectorAll('textarea.rt').forEach(function(el) {
        			CKEDITOR.replace(el, {
        				extraPlugins: 'autogrow',
        				autoGrow_onStartup: true,
						// Define changes to default configuration here.
						// For complete reference see:
						// http://docs.ckeditor.com/#!/api/CKEDITOR.config

						// The toolbar groups arrangement, optimized for a single toolbar row.
						toolbarGroups: [
							{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
							{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
							{ name: 'links' },
							{ name: 'insert' },
							{ name: 'tools' },
							{ name: 'others' }
						],

						// The default plugins included in the basic setup define some buttons that
						// are not needed in a basic editor. They are removed here.
						removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript',

						// Dialog windows are also simplified.
						removeDialogTabs: 'link:advanced'
					});
        		});
        	})
        </script>
    </head>
    <body>
<?php
//  require(dirname(__FILE__) . "/../views/_topbar.php");
?>
        <header>
<?php
    require(dirname(__FILE__) . "/../views/_navbar.php");
?>
        </header>
        <main>
            <div id="central" class="central">
                <div id="center-column">
<?php
    include(dirname(__FILE__) . "/../views/backend/_navbar.php");

    print $this->content_for_layout;
?>
                </div><!-- center-column -->
            </div>
        </main>
        <footer>
<?php
    require(dirname(__FILE__) . "/../views/_footer.php");
?>
        </footer>
    </body>
</html>

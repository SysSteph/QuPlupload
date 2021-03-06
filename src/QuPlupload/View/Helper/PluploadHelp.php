<?php
/**
 * @Author: Cel Ticó Petit
 * @Contact: cel@cenics.net
 * @Company: Cencis s.c.p.
 */

namespace QuPlupload\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PluploadHelp extends AbstractHelper
{

    /**
     * @var
     */
    protected $Config;

    /**
     * @param $Config
     */
    public function __construct($Config)
    {
        $this->Config = $Config;
    }

    /**
     * @param $name
     * @param int $id
     * @param $model
     */
    public function __invoke($name,$id = 0,$model)
    {

        $this->view->inlineScript()
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/i18n/es.js', 'text/javascript')
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/jquery.plupload.queue/jquery.plupload.queue.js', 'text/javascript')
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/plupload.html5.js', 'text/javascript')
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/plupload.html4.js', 'text/javascript')
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/plupload.browserplus.js', 'text/javascript')
        ->prependFile($this->view->basePath($this->Config['DirJs']) . '/js/plupload.js', 'text/javascript')
         ;
        ?> <script type="text/javascript">
            $(function() {
                $("#<?=$name?>").pluploadQueue({

                    runtimes: 'html5,gears,browserplus,html4',
                    url: '<?php echo $this->Config['UrlUpload']; ?>/<?php echo $id; ?>/<?php echo $model; ?>',
                    max_file_size: '20mb',
                    chunk_size: '1mb',
                    unique_names: false,
                    multiple_queues: true,
                    rename:true,
                    resize: { width:<?php echo $this->Config['Resize'][0]; ?>, height:<?php echo $this->Config['Resize'][1]; ?>, quality:100 },

                    init: {
                                StateChanged: function(up) {

                                    if(up.state == plupload.STARTED){
                                        console.log('STARTED"');
                                    } else{
                                        $('.PluploadLoad').load('<?=$this->Config['UrlLoad']?>/<?php echo $id; ?>/<?php echo $model; ?>');
                                    }

                                },

                                Error: function(up, args) {
                                    if (args.file) {
                                        console.log('[error]', args, "File:", args.file);
                                    } else {
                                        console.log('[error]', args);
                                    }
                                }
                         }
                });
            });

        </script> <?php

            /**
             * @package unfinished
             * @todo finish config parameters Plupload
             */

        }
    }
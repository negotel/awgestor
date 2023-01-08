<?php
    $__ks_limit=!empty($__ks_limit)?$__ks_limit:10;
	$isViewCount=Mapp_setting::GetSettingsValue("is_kn_iconc","N")=="N";
    $__stikeyArticle=Mknowledge::FindAllBy("is_stickey", "Y",array("status"=>"P"),'entry_time');
    $totalStikey=count($__stikeyArticle);
    if($totalStikey>0){
        $sliceItem=(int)($totalStikey/3);
        if($sliceItem<=0){
            $sliceItem=1;
        }
        $__stickey_chunk=array_chunk($__stikeyArticle, $sliceItem);
        
        //GPrint($__stickey_chunk);
        ?>

     

        <div class="row">
            <div class="col-12 article-box">
                <h2 class="art-title">
	                <?php _e("Pinned Articles") ; ?>
                </h2>
                <div class="row">
	                <?php foreach ($__stickey_chunk as $_sticky_box){?>
                        <div class="col-md-4 art-box m-b-0">
                            <div class="art-list">
				                <?php if(!empty($__stikeyArticle)){echo get_knowledge_list_artbox_2020($_sticky_box,true,$isViewCount); }?>

                            </div>
                        </div>
	                <?php }?>
                </div>
            </div>
        </div>
	
	    <?php
        
    }?>
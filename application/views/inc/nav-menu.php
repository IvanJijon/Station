			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<li <?php if ($this->uri->segment(1) == "") {echo "class='active'"; }?>>
                            <a href="<?php echo base_url();?>dashboard/"><i class="fa fa-dashboard fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-dashboard');?></span></a>
                        </li>
                       <?php /*?> <li <?php if ($this->uri->segment(1) == "") {echo "class='active'"; }?>>
                            <a href="<?php echo base_url();?>dashboard/"><i class="fa fa-dashboard fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-dashboard');?></span></a>
                        </li>
                        <?php if($this->main_model->isAccessModules('donnees')){?>
                        <li>
                        	<a href="<?php echo base_url();?>donnees/" ><i class="fa fa-database fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-donnees');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        	 <?php if($this->main_model->isAccessModules('fichiers-sources')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>donnees/liste_fichiers_sources"><i class="fa fa-file fa-fw"></i> <?php echo $this->lang->line('menu-fichiers-sources');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('historiques')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>donnees/liste_historiques"><i class="fa fa-history fa-fw"></i> <?php echo $this->lang->line('menu-historiques');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('fusions')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>donnees/liste_fusions"><i class="fa fa-refresh fa-fw"></i> <?php echo $this->lang->line('menu-fusions');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('fichiers-externes')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>donnees/liste_fichiers_externes"><i class="fa fa-clipboard fa-fw"></i> <?php echo $this->lang->line('menu-fichiers-externes');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('origines')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>donnees/liste_origines"><i class="fa fa-globe fa-fw"></i> <?php echo $this->lang->line('menu-origines');?></a>
                        		</li>
                        		<?php }?>
                        	</ul>
                        </li>
                        <?php }
                        if($this->main_model->isAccessModules('referentiels')){?>
                        <li>
                        	<a href="<?php echo base_url();?>referentiels/" ><i class="fa fa-list fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-referentiels');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        	<?php if($this->main_model->isAccessModules('regroupements')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>referentiels/liste_regroupements"><i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('menu-regroupements');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('tranches')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>referentiels/liste_tranches"><i class="fa fa-bar-chart fa-fw"></i> <?php echo $this->lang->line('menu-tranches');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('tranches')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>referentiels/liste_champs"><i class="fa fa-columns fa-fw"></i> <?php echo $this->lang->line('menu-champs-tranches');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('commentaires')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>referentiels/liste_commentaires"><i class="fa fa-comment fa-fw"></i> <?php echo $this->lang->line('menu-commentaires');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('anciennete')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>referentiels/liste_anciennetes"><i class="fa fa-university fa-fw"></i> <?php echo $this->lang->line('menu-anciennete');?></a>
                        		</li>
                        		<?php }?>
                        	</ul>
                        </li>
                        <?php }                        
                         if($this->main_model->isAccessModules('indicateurs')){?>
                        <li>
                        	<a href="<?php echo base_url();?>indicateurs/" ><i class="fa fa-sliders fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-indicateurs');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        		<?php if($this->main_model->isAccessModules('paie')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>indicateurs/liste_indicateurs_paie"><i class="fa fa-money fa-fw"></i> <?php echo $this->lang->line('menu-paie');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('mobilite')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>indicateurs/liste_indicateurs_mobilite"><i class="fa fa-car fa-fw"></i>  <?php echo $this->lang->line('menu-mobilite');?></a>
                        		</li>
                        		<?php }?>
                        	</ul>
                        </li>
                        <?php }                        
                         if($this->main_model->isAccessModules('archives')){?>
                        <li>
                        	<a href="<?php echo base_url();?>archives/" ><i class="fa fa-archive fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-archives');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        	<?php if($this->main_model->isAccessModules('gestion-archives')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>archives/liste_archives"><i class="fa fa-archive fa-fw"></i> <?php echo $this->lang->line('menu-gestion-archives');?></a>
                        		</li>
                        		<li>
                        			<a href="<?php echo base_url(); ?>archives/liste_types"><i class="fa fa-list-alt fa-fw"></i> <?php echo $this->lang->line('menu-types-archives');?></a>
                        		</li>
                        		<?php }?>
                        	</ul>
                        </li>
                        <?php if($this->main_model->isAccessModules('securite')){?>
                        <li>
                        	<a href="<?php echo base_url();?>securite/"><i class="fa fa-lock fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-securite');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        		<li>
                        			<a href="<?php echo base_url(); ?>securite/liste_utilisateurs"><i class="fa fa-users fa-fw"></i> <?php echo $this->lang->line('menu-securite-utilisateurs');?></a>
                        		</li>
                        		<li>
                        			<a href="<?php echo base_url(); ?>securite/liste_profils"><i class="fa fa-tags fa-fw"></i> <?php echo $this->lang->line('menu-securite-profils');?></a>
                        		</li>
                        		<li>
                        			<a href="<?php echo base_url(); ?>securite/gestion_permissions"><i class="fa fa-unlock fa-fw"></i> <?php echo $this->lang->line('menu-securite-permissions');?></a>
                        		</li>
                        	</ul>
                        </li>
                        <?php }                        
                         if($this->main_model->isAccessModules('configuration')){?>
                        <li>
                        	<a href="<?php echo base_url();?>configuration/"><i class="fa fa-cogs fa-fw"></i> <span class="tit_disp"><?php echo $this->lang->line('menu-configuration');?></span><span class="fa arrow"></span></a>
                        	<ul class="nav nav-second-level">
                        		
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('modules')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>configuration/liste_modules"><i class="fa fa-sitemap fa-fw"></i> <?php echo $this->lang->line('menu-modules');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('dictionnaires')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>configuration/liste_dictionnaires"><i class="fa fa-book fa-fw"></i> <?php echo $this->lang->line('menu-dictionnaires');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('sequences')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>configuration/liste_sequences"><i class="fa fa-briefcase fa-fw"></i> <?php echo $this->lang->line('menu-sequences');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('jobs')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>configuration/liste_jobs"><i class="fa fa-tty fa-fw"></i> <?php echo $this->lang->line('menu-jobs');?></a>
                        		</li>
                        		<?php }?>
                        		<?php if($this->main_model->isAccessModules('entete-donnees-externes')){?>
                        		<li>
                        			<a href="<?php echo base_url(); ?>configuration/liste_entetes_donnees_externes"><i class="fa fa-external-link fa-fw"></i> <?php echo $this->lang->line('menu-entete-donnees-externes');?></a>
                        		</li>
                        		<?php }?>
                        	</ul>
                        </li>
                         <?php }?>
                        <?php */
                        $listeMenu = $this->main_model->listeMenus();
                        	//On définit la colone profil propre à l'utilisateur
                        	foreach($listeMenu as $cat){
                        		if(count($cat->sousmenu)>0){
                        			if($this->main_model->isAccessModules($cat->CONF)){?>
			                        	<li>
			                           	 	<a href="#" ><i class="fa <?php echo $cat->ITEM_ICON;?> fa-fw"></i> <span class="tit_disp"><?php echo $cat->ITEM_NAME?></span><span class="fa arrow"></span></a>
			                           	 	<?php if(count($cat->sousmenu)>0){?>
			                           	 		<ul class="nav nav-second-level">
			                           	 			<?php foreach($cat->sousmenu as $menu){
			                           	 				if($this->main_model->isAccessModules($menu->config['conf'])){?>
							                                <li>
							                                    <a href="<?php echo base_url().$menu->config['controller']."/".$menu->config['fonction']; ?>"><i class="fa <?php echo $menu->ITEM_ICON;?> fa-fw"></i> <?php echo $menu->ITEM_NAME?></a>
							                                </li>
					                                <?php }
					                                }?>
					                            </ul>
			                           	 	<?php }?>
			                            </li>
			              		<?php }?>
                        	
                        	<?php }
                        		}?>  
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
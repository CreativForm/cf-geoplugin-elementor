<?php if ( ! defined( 'WPINC' ) ) { die( "Don't mess with us." ); }

if( !class_exists('CFGPE_Vat_Widget') ) :

class CFGPE_Vat_Widget extends \Elementor\Widget_Base {

	public static $slug = 'elementor-is-vat';

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() { return self::$slug; }

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() { return __('Value-added tax control', CFGPE_NAME); }

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() { return 'fa fa-eur'; }

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() { return [ 'geoplugin-addons' ]; }
	
	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$slug = self::$slug;


		/*
		 * CONTENT
		 */
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Options', CFGPE_NAME ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
			$this->add_control(
				'vat_control',
				array(
					'label'	=> __( 'Show or hide', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', CFGPE_NAME ),
					'label_off' => __( 'Hide', CFGPE_NAME ),
					'return_value' => true,
					'default' => true,
					'description' => __( 'You can choose whether to hide or show this widget for the visitors under VAT', CFGPE_NAME )
				)
			);
			
			$this->add_control(
				'content',
				array(
					'label' => __( 'Content', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => __( 'Your content goes here...', CFGPE_NAME ),
					'placeholder' => __( 'Place your content.', CFGPE_NAME ),
				)
			);
			
			$this->add_control(
				'preview',
				array(
					'label'	=> __( 'Preview mode', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Preview', CFGPE_NAME ),
					'label_off' => __( 'Normal', CFGPE_NAME ),
					'return_value' => true,
					'default' => true,
					'description' => __( 'This is an administrator-only option. Leave it enabled so you can see the content you are editing.', CFGPE_NAME )
				)
			);
		$this->end_controls_section();
		
		
		/*
		 * STYLE
		 */
		$class = '{{WRAPPER}} ' . ".cf-geoplugin-{$slug}";
		$this->start_controls_section(
			'style_section_0',
			array(
				'label' => __( 'Content style', CFGPE_NAME ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'content_typography',
					'label' => __( 'Typography', CFGPE_NAME ),
					'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
					'selector' => "{$class}, {$class} p"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'content_typography_link',
					'label' => __( 'Link typography', CFGPE_NAME ),
					'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
					'selector' => "{$class} a, {$class} a:active"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'content_typography_link_hover',
					'label' => __( 'Link hover typography', CFGPE_NAME ),
					'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
					'selector' => "{$class} a:hover, {$class} a:focus"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				array(
					'name' => 'text_shadow',
					'label' => __( 'Text Shadow', CFGPE_NAME ),
					'selector' => "{$class}, {$class} p"
				)
			);
		
		$this->end_controls_section();

		for($i = 1; $i<=6; $i++)
		{
			$this->start_controls_section(
				"style_section_{$i}",
				array(
					'label' => __( "Heading H{$i}", CFGPE_NAME ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
			
				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					array(
						'name' => "heading_typography_{$i}",
						'label' => __( 'Typography', CFGPE_NAME ),
						'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
						'selector' => "{$class} h{$i}"
					)
				);
				
				$this->add_group_control(
					\Elementor\Group_Control_Text_Shadow::get_type(),
					array(
						'name' => "heading_text_shadow_{$i}",
						'label' => __( 'Text Shadow', CFGPE_NAME ),
						'selector' => "{$class} h{$i}"
					)
				);
				
				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					array(
						'name' => "heading_border_{$i}",
						'label' => __( 'Border', CFGPE_NAME ),
						'selector' => "{$class} h{$i}"
					)
				);
				
				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					array(
						'name' => "heading_background_{$i}",
						'label' => __( 'Background', CFGPE_NAME ),
						'types' => [ 'classic', 'gradient', 'video' ],
						'selector' => "{$class} h{$i}"
					)
				);
			
			$this->end_controls_section();
		}

		$this->start_controls_section(
			'style_section_blockquote',
			array(
				'label' => __( 'Blockquote', CFGPE_NAME ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name' => 'content_typography_blockquote',
					'label' => __( 'Typography', CFGPE_NAME ),
					'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3,
					'selector' => "{$class} blockquote"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				array(
					'name' => 'text_shadow_blockquote',
					'label' => __( 'Text Shadow', CFGPE_NAME ),
					'selector' => "{$class} blockquote"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				array(
					'name' => 'blockquote_border',
					'label' => __( 'Border', CFGPE_NAME ),
					'selector' => "{$class} blockquote"
				)
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'blockquote_background',
					'label' => __( 'Background', CFGPE_NAME ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => "{$class} blockquote"
				]
			);
		
		$this->end_controls_section();
	}
	
	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		global $post, $CFGEO;
		$settings = $this->get_settings_for_display();
		
		if(empty($CFGEO)) {
			$CFGEO = $GLOBALS['CFGEO'];
		}
		
		if(empty($CFGEO)) return;
		
		$show = false;
		
		if($settings['vat_control'] && isset($CFGEO['is_vat']) && $CFGEO['is_vat'] == 1)
			$show = true;
		
		if(!$settings['vat_control'] && isset($CFGEO['is_vat']) && $CFGEO['is_vat'] == 0)
			$show = true;

		if(self::is_edit() && $settings['preview'])
			$show = true;
		
		if( $show && !empty($settings['content'])) : ?>
			<div class="elementor-text-editor elementor-clearfix elementor-inline-editing <?php echo self::$slug; ?> cf-geoplugin-<?php echo self::$slug; ?>">
				<?php echo do_shortcode($settings['content']); ?>
			</div>
		<?php endif;
	}
	
	/**
	 * Check if is in edit mode
	 *
	 * Return true/false
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function is_edit()
	{
		return \Elementor\Plugin::$instance->editor->is_edit_mode();
	}
} 

endif;
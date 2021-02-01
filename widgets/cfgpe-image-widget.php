<?php if ( ! defined( 'WPINC' ) ) { die( "Don't mess with us." ); }

if( !class_exists('CFGPE_Image_Widget') ) :

class CFGPE_Image_Widget extends \Elementor\Widget_Base {

	public static $slug = 'cf-geoplugin-elementor-image';

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
	public function get_title() { return __('Geo Image', CFGPE_NAME); }

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
	public function get_icon() { return 'fa fa-image'; }

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
		global $_wp_additional_image_sizes;

		$default_image_sizes = get_intermediate_image_sizes();
		$image_sizes = $image_sizes_prep = [];
	
		foreach ( $default_image_sizes as $size ) {
			$image_sizes_prep[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
			$image_sizes_prep[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
			$image_sizes_prep[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
		}
	
		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
			$image_sizes_prep = array_merge( $image_sizes_prep, $_wp_additional_image_sizes );
		}
		
		foreach($image_sizes_prep as $key=>$prep){
			$image_sizes[$key]= $key;
		}

		$slug = self::$slug;
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Image settings', CFGPE_NAME ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
			$repeater = new \Elementor\Repeater();

			$repeater->add_control(
				'image',
				[
					'label' => __( 'Choose Image', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
		
			$repeater->add_control(
				'image_size',
				[
					'label' => __( 'Image Size', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'large',
					'options' => $image_sizes,
				]
			);
			
			$repeater->add_control(
				'location',
				[
					'label' => __( 'Display Location', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Comma separated city, region, country, continent name or the code where you want to display this image.', CFGPE_NAME ),
					'placeholder' => __( 'US, Toronto, Europe...', CFGPE_NAME ),
				]
			);
			
			$repeater->add_control(
				'alt',
				[
					'label' => __( 'Alt', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Alternate image title.', CFGPE_NAME ),
				]
			);
			
			$repeater->add_control(
				'link',
				[
					'label' => __( 'Link', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', CFGPE_NAME ),
					'show_external' => true,
					'default' => [
						'url' => '',
					],
				]
			);
			
		$this->add_control(
			'list',
			[
				'label' => __( 'Coose image for each geolocation', CFGPE_NAME ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => '{{{ location }}}',
			]
		);
		
		$this->add_control(
			'default_options',
			[
				'label' => __( 'Default Options', CFGPE_NAME ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
			$this->add_control(
				'enable_default_image',
				[
					'label' => __( 'Enable Default Image', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', CFGPE_NAME ),
					'label_off' => __( 'No', CFGPE_NAME ),
					'return_value' => 'yes',
					'default' => '',
				]
			);
			
			$this->add_control(
				'default_image',
				[
					'label' => __( 'Default Image', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
		
			$this->add_control(
				'default_image_size',
				[
					'label' => __( 'Default Image Size', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'large',
					'options' => $image_sizes,
				]
			);
			
			$this->add_control(
				'default_alt',
				[
					'label' => __( 'Default Alt', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Default alternate image title.', CFGPE_NAME ),
				]
			);
			
			$this->add_control(
				'default_link',
				[
					'label' => __( 'Default Link', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', CFGPE_NAME ),
					'show_external' => true,
					'default' => [
						'url' => '',
					],
				]
			);
		
		$this->end_controls_section();
		
		$slug = self::$slug;
		
		$class = '{{WRAPPER}} ' . ".{$slug}";
		
		
		$this->start_controls_section(
			'style_section_0',
			[
				'label' => __( 'Image Settings', CFGPE_NAME ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			
			$this->add_responsive_control(
				'image_align',
				[
					'label' => __( 'Image Alignment', CFGPE_NAME ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'options' => [
						'0 auto 0 0' => [
							'title' => __( 'Left', CFGPE_NAME ),
							'icon' => 'fa fa-align-left',
						],
						'0 auto' => [
							'title' => __( 'Center', CFGPE_NAME ),
							'icon' => 'fa fa-align-center',
						],
						'0 0 0 auto' => [
							'title' => __( 'Right', CFGPE_NAME ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => '0 auto',
					'toggle' => true,
					'selectors' => [
						"{$class}" => 'margin: {{VALUE}}',
					],
				]
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'label' => __( 'Image Border', CFGPE_NAME ),
					'selector' => "{$class}"
				]
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'image_shadow',
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'label' => __( 'Image Shadow', CFGPE_NAME ),
					'selector' => "{$class}"
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
		
		$image = [
			'ID' => NULL,
			'url' => NULL,
			'size' => NULL,
			'alt' => NULL,
			'link' => NULL
		];

		if($settings['enable_default_image'] == 'yes')
		{
			if(empty($settings['default_image']['id'])){
				echo '<strong>-- ' . __('You must define a default image for this option to work.', CFGPE_NAME) . ' --</strong>';
				return;
			}
			
			$image = [
				'ID' => $settings['default_image']['id'],
				'url' => $settings['default_image']['url'],
				'size' => $settings['default_image_size'],
				'alt' => $settings['default_alt'],
				'link' => $settings['default_link']
			];
		}
		else
		{
			if(empty($settings['list'])){
				echo '<strong>' . __('Please define one or more images.', CFGPE_NAME) . '</strong>';
				return;
			}
		}
		
		foreach($settings['list'] as $i=>$fetch)
		{
			if($this->recursive_array_search($fetch['location'], $CFGEO)){		
				$image = [
					'ID' => $fetch['image']['id'],
					'url' => $fetch['image']['url'],
					'size' => $fetch['image_size'],
					'alt' => $fetch['alt'],
					'link' => $fetch['link']
				];
				break;
			}
		}
		
		$target = $image['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $image['link']['nofollow'] ? ' rel="nofollow"' : '';
		
//		echo '<pre>', var_dump($image), '</pre>';

		if(!empty($image['link']['url'])){
			echo '<a href="' . $image['link']['url'] . '"' . $target . $nofollow . '>';
		}

		echo wp_get_attachment_image(
			$image['ID'],
			$image['size'],
			false,
			[
				'class' => self::$slug,
				'alt'	=> $image['alt']
			]
		);
		
		if(!empty($image['link']['url'])){
			echo '</a>';
		}
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
	
	public function recursive_array_search($needle,$haystack) {
		if(!empty($needle) && !empty($haystack) && is_array($haystack))
		{
			foreach($haystack as $key=>$value)
			{
				if(is_array($value)===true)
				{
					return $this->recursive_array_search($needle,$value);
				}
				else
				{
					/* ver 1.1.0 */
					$value = trim($value);
					$needed = array_filter(array_map('trim',explode(',',$needle)));
					foreach($needed as $need)
					{
						if(strtolower($need)==strtolower($value))
						{
							return $value;
						}
					}
				}
			}
		}
		return false;
    }
} 

endif;
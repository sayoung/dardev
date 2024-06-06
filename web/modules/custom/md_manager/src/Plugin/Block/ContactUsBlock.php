<?php declare(strict_types=1);

namespace Drupal\md_manager\Plugin\Block;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\Config;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\webform\Entity\Webform;


/**
 * Provides a steps process block.
 *
 * @Block(
 *   id = "md_manager_contact_us",
 *   admin_label = @Translation("Contact us"),
 *   category = @Translation("Custom"),
 * )
 */
final class ContactUsBlock extends BlockBase implements ContainerFactoryPluginInterface
{



  protected $entityTypeManager;

  protected $languageManager;

  /**
   * The configuration object.
   *
   * @var Config
   */
  protected $config;

  /**
   * Constructs a new CustomFormBlock.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param Config $config
   *   The configuration object.
   */
  public function __construct(
                              array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              Config $config,
                              EntityTypeManagerInterface $entityTypeManager,
                              LanguageManagerInterface $languageManager
  )
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config = $config;
    $this->entityTypeManager = $entityTypeManager;
    $this->languageManager = $languageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface|\Symfony\Component\DependencyInjection\ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')->get('md_manager.settings'),
      $container->get('entity_type.manager'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array
  {
    $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
   // dump($this->config->get($lang . '.address'));die;

    $webform_id = 'contact'; // Replace 'your_webform_id' with the actual webform ID.
    $webform = Webform::load($webform_id);

    // Check if the webform exists.
    if ($webform) {
      // Build the webform render array.
      $webform_render_array = [
        '#type' => 'webform',
        '#webform' => $webform,
      ];
    } else {
      $webform_render_array = [
        '#markup' => t('Webform not found.'),
      ];
    }


    $contact = [
      'description' => $this->config->get($lang . '.description'),
      'address' => $this->config->get($lang . '.address'),
      'phone' => $this->config->get($lang . '.phone'),
      'email' => $this->config->get($lang . '.email'),

    ];

    return [
      '#theme' => 'contact_us',
      '#content' => $contact,
      '#webform' => $webform_render_array,
    ];
  }


}

<?php
/**
 * @file
 * Contains \Drupal\telegram\Form\ConfigModule.
 *
 * В комментарии выше указываем, что содержится в данном файле.
 */

// Объявляем пространство имён формы. Drupal\НАЗВАНИЕ_МОДУЛЯ\Form
namespace Drupal\telegram\Form;

// Указываем что нам потребуется ConfigFormBase, от которого мы будем наследоваться
// а также FormStateInterface который позволит работать с данными.
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Объявляем нашу форму, наследуясь от ConfigFormBase.
 * Название класса строго должно соответствовать названию файла.
 */
class ConfigModule extends ConfigFormBase {

  /**
   * То что ниже - это аннотация. Аннотации пишутся в комментариях и в них
   * объявляются различные данные. В данном случае указано, что документацию
   * к данному методу надо взять из комментария к самому классу.
   *
   * А в самом методе мы возвращаем название нашей формы в виде строки.
   * Эта строка используется для альтера формы (об этом ниже в тексте).
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'config_telegram_post';
  }

   protected function getEditableConfigNames() {
    // Возвращает названия конфиг файла.
    // Значения будут храниться в файле:
    // helloworld.collect_phone.settings.yml
    return [
      'telegram.config_post.settings',
    ];
  }  
  /**
   * Создание нашей формы.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) 
  {
    // Загружаем наши конфиги.
    $config = $this->config('telegram.config_post.settings');
    // Добавляем поле для возможности задать телефон по умолчанию.
    // Далее мы будем использовать это значение в предыдущей форме.
    $form['default_chat_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Default id chat'),
      '#default_value' => $config->get('chat_id'),
    );
	$form['default_token'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Default token'),
      '#default_value' => $config->get('token'),
    );
    // Субмит наследуем от ConfigFormBase
    return parent::buildForm($form, $form_state);
  }


  /**
   * Отправка формы.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    // Записываем значения в наш конфиг файл и сохраняем.
    
    $this->config('telegram.config_post.settings')->set('chat_id', $values['default_chat_id'])->save();
	$this->config('telegram.config_post.settings')->set('token', $values['default_token'])->save();

  }

}
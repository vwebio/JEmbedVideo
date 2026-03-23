# JEmbedVideo

Модуль Joomla 5.2 для встраивания видео с YouTube, Rutube и VK Video с живым предпросмотром в админке и выводом на фронте.

## Возможности

- Вставка видео по URL из:
  - YouTube
  - Rutube
  - VK Video
- Автоматическое преобразование публичной ссылки в embed URL.
- Живой предпросмотр iframe в параметрах модуля в админке.
- Вывод описания под видео на фронтенде.
- Базовый CSS-режим или наследование стилей шаблона.

## Требования

- Joomla 5.2+
- PHP, совместимый с требованиями Joomla 5.2

## Структура модуля

```text
mod_jembedvideo/
├─ language/ru-RU/
│  ├─ mod_jembedvideo.ini
│  └─ mod_jembedvideo.sys.ini
├─ media/css/style.css
├─ services/provider.php
├─ src/
│  ├─ Field/VideopreviewField.php
│  └─ Helper/JEmbedVideoHelper.php
├─ tmpl/default.php
├─ mod_jembedvideo.php
└─ mod_jembedvideo.xml
```

## Архитектура и точки входа

- `mod_jembedvideo.xml`
  - Манифест установки.
  - Базовый namespace: `Brintek\Module\JEmbedVideo`.
  - Префикс кастомных полей: `Brintek\Module\JEmbedVideo\Site\Field`.
- `mod_jembedvideo.php`
  - Точка входа модуля.
  - Читает параметры, получает embed URL через helper, подключает layout.
- `src/Helper/JEmbedVideoHelper.php`
  - Логика парсинга URL и сборки iframe-ссылок.
- `src/Field/VideopreviewField.php`
  - Кастомное поле админки `videopreview`.
  - Показывает iframe-превью сразу при вводе URL.
- `tmpl/default.php`
  - Рендер плеера и описания на фронтенде.

## Параметры в админке

- `video_url` — ссылка на видео.
- `video_preview` — динамический iframe предпросмотр в форме модуля.
- `video_description` — описание под видео.
- `style_mode`:
  - `basic` — подключается `media/css/style.css`
  - `inherit` — стили от шаблона

## Установка на Joomla 5.2

1. Подготовьте архив модуля `mod_jembedvideo.zip`.
2. Внутри архива в корне должны лежать файлы модуля (`mod_jembedvideo.xml`, `mod_jembedvideo.php`, `src/`, `tmpl/` и т.д.).
3. В админке Joomla откройте: **Система → Установка расширений**.
4. Загрузите архив `mod_jembedvideo.zip`.
5. Перейдите в **Контент → Модули сайта** и откройте `JEmbedVideo`.
6. Заполните:
   - Заголовок
   - URL видео
7. Проверьте, что в поле предпросмотра появился iframe.
8. Выберите позицию, включите модуль и сохраните.
9. Откройте фронтенд и проверьте отображение видео в выбранной позиции.

## Обновление модуля

- Если менялись `namespace`, `addfieldprefix` или PHP-классы, рекомендуется:
  - удалить установленный экземпляр модуля,
  - установить обновлённый архив заново,
  - очистить кэш Joomla.

## Частые проблемы

- `Class "...Helper\JEmbedVideoHelper" not found`
  - Обычно установлена старая сборка или неактуальный namespace.
  - Переустановите модуль из актуального архива.

- `Class "Joomla\CMS\Form\Field\FormField" not found`
  - Неверный импорт базового класса поля формы.
  - Должно быть: `use Joomla\CMS\Form\FormField;`

- В админке вместо предпросмотра обычный `input`
  - Не загружен кастомный field-класс.
  - Проверьте `addfieldprefix` и переустановку модуля.



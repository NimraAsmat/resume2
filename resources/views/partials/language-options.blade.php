@foreach([
  'Abkhaz', 'Afar', 'Afrikaans', 'Akan', 'Albanian', 'Amharic', 'Arabic', 'Aragonese', 'Armenian',
  'Assamese', 'Avaric', 'Avestan', 'Aymara', 'Azerbaijani', 'Bambara', 'Bashkir', 'Basque', 'Belarusian',
  'Bengali', 'Bihari', 'Bislama', 'Bosnian', 'Breton', 'Bulgarian', 'Burmese', 'Catalan', 'Chamorro',
  'Chechen', 'Chichewa', 'Chinese', 'Chuvash', 'Cornish', 'Corsican', 'Cree', 'Croatian', 'Czech',
  'Danish', 'Divehi', 'Dutch', 'Dzongkha', 'English', 'Esperanto', 'Estonian', 'Ewe', 'Faroese',
  'Fijian', 'Finnish', 'French', 'Fula', 'Galician', 'Georgian', 'German', 'Greek', 'Guaraní',
  'Gujarati', 'Haitian', 'Hausa', 'Hebrew', 'Herero', 'Hindi', 'Hiri Motu', 'Hungarian', 'Icelandic',
  'Ido', 'Igbo', 'Indonesian', 'Interlingua', 'Interlingue', 'Inuktitut', 'Inupiaq', 'Irish', 'Italian',
  'Japanese', 'Javanese', 'Kalaallisut', 'Kannada', 'Kanuri', 'Kashmiri', 'Kazakh', 'Khmer', 'Kikuyu',
  'Kinyarwanda', 'Kirghiz', 'Komi', 'Kongo', 'Korean', 'Kurdish', 'Kwanyama', 'Lao', 'Latin', 'Latvian',
  'Limburgish', 'Lingala', 'Lithuanian', 'Luba-Katanga', 'Luganda', 'Luxembourgish', 'Macedonian',
  'Malagasy', 'Malay', 'Malayalam', 'Maltese', 'Manx', 'Maori', 'Marathi', 'Marshallese', 'Mongolian',
  'Nauru', 'Navajo', 'Ndonga', 'Nepali', 'North Ndebele', 'Northern Sami', 'Norwegian', 'Norwegian Bokmål',
  'Norwegian Nynorsk', 'Nuosu', 'Occitan', 'Ojibwe', 'Old Church Slavonic', 'Oriya', 'Oromo', 'Ossetian',
  'Pāli', 'Pashto', 'Persian', 'Polish', 'Portuguese', 'Punjabi', 'Quechua', 'Romanian', 'Romansh',
  'Russian', 'Samoan', 'Sango', 'Sanskrit', 'Sardinian', 'Serbian', 'Shona', 'Sindhi', 'Sinhala',
  'Slovak', 'Slovene', 'Somali', 'South Ndebele', 'Southern Sotho', 'Spanish', 'Sundanese', 'Swahili',
  'Swati', 'Swedish', 'Tagalog', 'Tahitian', 'Tajik', 'Tamil', 'Tatar', 'Telugu', 'Thai', 'Tibetan',
  'Tigrinya', 'Tonga', 'Tsonga', 'Tswana', 'Turkish', 'Turkmen', 'Twi', 'Uyghur', 'Ukrainian', 'Urdu',
  'Uzbek', 'Venda', 'Vietnamese', 'Volapük', 'Walloon', 'Welsh', 'Western Frisian', 'Wolof', 'Xhosa',
  'Yiddish', 'Yoruba', 'Zhuang', 'Zulu'
] as $language)
  <option value="{{ $language }}">{{ $language }}</option>
@endforeach
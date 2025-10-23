<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Builder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <style>
    .iti {
      width: 100% !important;
    }
    .iti__selected-flag {
      background-color: #dbeafe !important;
      border-radius: 0.25rem 0 0 0.25rem !important;
    }
    .iti__country-list {
      width: 500% !important;
    }
 
    .live-preview-container {
      transition: all 0.3s ease-in-out;
    }
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .auto-save-indicator {
      transition: all 0.3s ease;
    }
    
    .saving {
      background-color: #f59e0b;
      animation: pulse 1.5s infinite;
    }
    
    .saved {
      background-color: #10b981;
    }
    
    .error {
      background-color: #ef4444;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .hidden {
      display: none !important;
    }
    
    .template-image {
      height: 400px; 
      object-fit: cover;
      width: 100%;
    }
    
    .template-card {
      transition: all 0.3s ease;
      cursor: pointer;
    }
    
    .template-card:hover {
      transform: translateY(-5px);
    }
    
    .template-card.selected {
      border-color: #3b82f6;
      box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
    }
    
    .page-transition {
      transition: all 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-gray-50 font-sans">
  <main class="max-w-7xl mx-auto mt-8 p-6">
    
   
    <div id="formPage" class="page-transition">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
      
        <div class="bg-white shadow-xl rounded-2xl p-8">
        
          <div class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-100">
            <div class="flex justify-between items-center">
              <div class="flex items-center space-x-4">
                <div id="autoSaveIndicator" class="w-3 h-3 bg-gray-400 rounded-full auto-save-indicator"></div>
                <div>
                  <span id="autoSaveText" class="text-sm font-semibold text-gray-700">Idle</span>
                  <div id="lastSaved" class="text-xs text-gray-500 mt-1"></div>
                </div>
              </div>
              <button type="button" onclick="clearDraft()" class="text-xs text-red-500 hover:text-red-700 font-medium">
                Clear Draft
              </button>
            </div>
          </div>

          <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-3">Resume Progress</h2>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
              <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-500" style="width:0%"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mt-2">
              <span class="font-medium">Get Started</span>
              <span id="progressText" class="font-semibold">0% Complete</span>
            </div>
          </div>

          <div id="messageContainer" class="hidden mb-6 p-4 rounded-xl border-l-4"></div>

          <form method="POST" action="<?php echo e(route('resume.download')); ?>" id="resumeForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="template" id="selectedTemplate" value="">
            <input type="hidden" name="phone" id="fullPhone">

            <section class="space-y-6 mb-8">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Personal Details</h3>
                <p class="text-gray-600 text-sm">Enter your basic personal information, such as your name, contact details, and nationality.</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">First Name</label>
                  <input type="text" name="first_name" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Last Name</label>
                  <input type="text" name="last_name" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                  <input type="email" name="email" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Phone Number</label>
                  <div class="relative">
                    <input type="tel" id="phone" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field">
                  </div>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Occupation</label>
                  <input type="text" name="occupation" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Country</label>
                  <select name="country" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                    <option value="">Select Country</option>
                     <?php echo $__env->make('partials.country-options', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                  </select>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Date of Birth</label>
                  <input type="date" name="dob" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                </div>
                <div>
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Nationality</label>
                  <select name="nationality" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                    <option value="">Select Nationality</option>
                     <?php echo $__env->make('partials.nationality-options', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                  </select>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Gender</label>
                <select name="gender" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                  <option value="Prefer not to say">Prefer not to say</option>
                </select>
              </div>
            </section>

            <section id="additionalDetails" class="space-y-6 mt-8 hidden">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Additional Details</h3>
                <p class="text-gray-600 text-sm">Include hobbies, interests, or personal achievements.</p>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Hobbies</label>
                <textarea name="hobbies" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 additional-field" placeholder="e.g., Reading, Traveling, Photography" oninput="handleInputChange()" rows="3"></textarea>
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Interests</label>
                <textarea name="interests" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 additional-field" placeholder="e.g., AI Technology, Environmental Conservation" oninput="handleInputChange()" rows="3"></textarea>
              </div>
            </section>

            <div class="text-center my-8">
              <button type="button" onclick="toggleAdditional()" class="px-8 py-3 font-bold border-2 border-blue-500 text-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <span id="additionalIcon" class="text-lg">+</span> 
                <span id="additionalText" class="ml-2">Show Additional Details</span>
              </button>
            </div>

            <section class="space-y-6 mb-8">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional Summary</h3>
                <p class="text-gray-600 text-sm">Provide a brief overview of your professional background and career objectives.</p>
              </div>
              <div>
                <textarea name="summary" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" placeholder="Enter your professional summary..." oninput="handleInputChange()" rows="5"></textarea>
              </div>
            </section>

            <section class="mt-8 space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Employment History</h3>
                <p class="text-gray-600 text-sm">List your previous jobs in reverse chronological order.</p>
              </div>
              <div id="employmentContainer"></div>
              <div class="text-center">
                <button type="button" onclick="addEmployment()" class="px-6 py-3 font-bold border-2 border-blue-500 text-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                  <span class="text-blue-600 text-lg">+</span> 
                  <span class="ml-2">Add Job</span>
                </button>
              </div>
            </section>

            <section class="mt-8 space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Education</h3>
                <p class="text-gray-600 text-sm">Enter your academic qualifications and institutions.</p>
              </div>
              <div id="educationContainer"></div>
              <div class="text-center">
                <button type="button" onclick="addEducation()" class="px-6 py-3 font-bold border-2 border-blue-500 text-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                  <span class="text-blue-600 text-lg">+</span> 
                  <span class="ml-2">Add Education</span>
                </button>
              </div>
            </section>

            <section class="mt-8 space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Languages</h3>
                <p class="text-gray-600 text-sm">Select the languages you know and your proficiency level.</p>
              </div>
              <div id="languageContainer"></div>
              <div class="text-center">
                <button type="button" onclick="addLanguage()" class="px-6 py-3 font-bold border-2 border-blue-500 text-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                  <span class="text-blue-600 text-lg">+</span> 
                  <span class="ml-2">Add Language</span>
                </button>
              </div>
            </section>

            <section class="mt-8 space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Skills</h3>
                <p class="text-gray-600 text-sm">Include key skills, technical abilities, and tools you are proficient in.</p>
              </div>
              <div id="skillsContainer"></div>
              <div class="text-center">
                <button type="button" onclick="addSkill()" class="px-6 py-3 font-bold border-2 border-blue-500 text-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                  <span class="text-blue-600 text-lg">+</span> 
                  <span class="ml-2">Add Skill</span>
                </button>
              </div>
            </section>
          </form>
        </div>

    
        <div class="bg-white shadow-xl rounded-2xl p-8 sticky top-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span>Live Preview</span>
            <span id="autoSaveStatus" class="ml-3 text-xs bg-green-100 text-green-800 px-3 py-1.5 rounded-full font-medium hidden">
              Auto-saved
            </span>
          </h3>
          
          <div id="livePreview" class="live-preview-container border-2 border-dashed border-gray-300 rounded-2xl p-8 min-h-[600px] flex items-center justify-center">
            <div class="text-center text-gray-500">
              <div class="text-6xl mb-4">📝</div>
              <p class="text-xl font-semibold mb-2">Please select a template</p>
              <p class="text-gray-600">Choose a template to see your resume preview</p>
            </div>
          </div>
          
        
          <div class="mt-8 flex justify-center gap-4 flex-wrap">
            <button type="button" onclick="showTemplatePage()" class="px-8 py-4 font-bold text-blue-600 border-2 border-blue-600 bg-white rounded-xl hover:bg-blue-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
              Select Template
            </button>
            
            <button type="button" onclick="saveDraft()" class="px-8 py-4 font-bold text-green-600 border-2 border-green-600 bg-white rounded-xl hover:bg-green-50 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
              Save Draft
            </button>
            
            <button type="button" onclick="validateForm()" class="px-8 py-4 font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
              Download PDF
            </button>
          </div>

          <div id="templatePreviewInfo" class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200 text-sm hidden">
            <strong class="text-blue-800">Selected Template:</strong> 
            <span id="currentTemplateName" class="font-semibold text-blue-900"></span>
            <p class="text-xs text-blue-700 mt-1" id="templateDescription"></p>
          </div>
        </div>
      </div>
    </div>

   
    <div id="templatePage" class="page-transition hidden">
      
      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-3xl font-bold text-gray-900">Choose Your Resume Template</h2>
          <p class="text-gray-600 mt-2">Select a template that best fits your professional style</p>
        </div>
        <button type="button" onclick="showFormPage()" class="px-6 py-3 font-semibold text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 hover:shadow-lg transition-all duration-200">
          Back to Form
        </button>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="templatesContainer">
      
      </div>
    </div>
  </main>

  <script>
    let phoneInput;
    let autoSaveInterval;
    let formChanged = false;
    let lastSaveTime = null;

    let employmentCounter = 0;
    let educationCounter = 0;
    let languageCounter = 0;
    let skillCounter = 0;

    document.addEventListener('DOMContentLoaded', function() {
        initializePhoneInput();
        initializeAutoSave();
        loadDraft();
        updateProgress();
        loadTemplates();
        
        document.querySelectorAll('input, textarea, select').forEach(element => {
            element.addEventListener('input', handleInputChange);
        });

        addEmployment();
        addEducation();
        addLanguage();
        addSkill();
    });

   
    function showTemplatePage() {
        document.getElementById('formPage').classList.add('hidden');
        document.getElementById('templatePage').classList.remove('hidden');
    }

    function showFormPage() {
        document.getElementById('templatePage').classList.add('hidden');
        document.getElementById('formPage').classList.remove('hidden');
    }

    function loadTemplates() {
        const templates = [
            {
                id: 'template1',
                name: 'Professional Blue',
                category: 'Professional',
                image: '/images/templates/professional-blue.jpg',
                description: 'Clean and professional design with blue accents, perfect for corporate environments.',
                view_name: 'template1'
            },
            {
                id: 'template2',
                name: 'Modern Black',
                category: 'Modern',
                image: '/images/templates/modern-black.jpg',
                description: 'Contemporary design with dark accents and clean lines for modern industries.',
                view_name: 'template2'
            },
            {
                id: 'template3',
                name: 'Creative Green',
                category: 'Creative',
                image: '/images/templates/creative-green.jpg',
                description: 'Fresh and creative design with green theme for design and marketing fields.',
                view_name: 'template3'
            }
        ];

        const container = document.getElementById('templatesContainer');
        container.innerHTML = '';

        templates.forEach(template => {
            const templateCard = `
                <div class="template-card bg-white rounded-2xl shadow-lg border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300 cursor-pointer group" onclick="selectTemplate('${template.id}', '${template.name}', '${template.description}', '${template.view_name}', this)">
                    <div class="h-96 rounded-t-2xl overflow-hidden"> <!-- Changed from h-64 to h-96 -->
                        <img src="${template.image}" alt="${template.name}" class="template-image w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                             onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAwIiBoZWlnaHQ9IjI1MCIgdmlld0JveD0iMCAwIDMwMCAyNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzMDAiIGhlaWdodD0iMjUwIiBmaWxsPSIjRjNGNEY2Ii8+Cjx0ZXh0IHg9IjUwJSIgeT0iNDUlIiBkb21pbmFudC1iYXNlbGluZT0iY2VudHJhbCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iOTlBQUFCIiBmb250LXNpemU9IjE2IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPlJlc3VtZSBUZW1wbGF0ZTwvdGV4dD4KPHRleHQgeD0iNTAlIiB5PSI2NSUiIGRvbWluYW50LWJhc2VsaW5lPSJjZW50cmFsIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjNjY3Nzg4IiBmb250LXNpemU9IjEyIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiPkltYWdlIG5vdCBhdmFpbGFibGU8L3RleHQ+Cjwvc3ZnPg=='">
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">${template.category}</span>
                                <h3 class="text-xl font-bold text-gray-900 mt-2">${template.name}</h3>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">${template.description}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-blue-600 text-sm font-semibold">Select Template</span>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', templateCard);
        });
    }

    function selectTemplate(templateId, templateName, templateDescription, viewName, element) {
        
        document.querySelectorAll('.template-card').forEach(card => {
            card.classList.remove('selected', 'border-blue-500', 'ring-2', 'ring-blue-500');
        });
        
        
        element.classList.add('selected', 'border-blue-500', 'ring-2', 'ring-blue-500');
        
        document.getElementById('selectedTemplate').value = templateId;
        
        document.getElementById('currentTemplateName').textContent = templateName;
        document.getElementById('templateDescription').textContent = templateDescription;
        document.getElementById('templatePreviewInfo').classList.remove('hidden');
        

        showFormPage();
        refreshPreview();
        showMessage(`Template selected: ${templateName}`, 'success');
    }

    function initializePhoneInput() {
        phoneInput = window.intlTelInput(document.querySelector("#phone"), {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            preferredCountries: ['us', 'gb', 'ca', 'au'],
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch("https://ipapi.co/country/")
                    .then(response => response.text())
                    .then(countryCode => callback(countryCode))
                    .catch(() => callback("us"));
            }
        });

        document.getElementById('phone').addEventListener('input', function() {
            handleInputChange();
            if (phoneInput.isValidNumber()) {
                document.getElementById('fullPhone').value = phoneInput.getNumber();
            }
        });
    }

    function handleInputChange() {
        formChanged = true;
        updateProgress();
        debouncedPreviewUpdate();
    }

    function getFormData() {
        const form = document.getElementById('resumeForm');
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (key.endsWith('[]')) {
                const baseKey = key.slice(0, -2);
                if (!data[baseKey]) {
                    data[baseKey] = [];
                }
                data[baseKey].push(value);
            } else {
                data[key] = value;
            }
        }
        
        if (phoneInput.isValidNumber()) {
            data['phone'] = phoneInput.getNumber();
        } else {
            data['phone'] = document.getElementById('phone').value;
        }
        
        data['template'] = document.getElementById('selectedTemplate').value;
        
        return data;
    }

    function initializeAutoSave() {
        autoSaveInterval = setInterval(() => {
            if (formChanged) {
                saveDraft();
            }
        }, 10000); 
    }

    function updateAutoSaveStatus(status) {
        const indicator = document.getElementById('autoSaveIndicator');
        const text = document.getElementById('autoSaveText');
        
        indicator.className = 'w-3 h-3 rounded-full auto-save-indicator';
        text.className = 'text-sm font-semibold';
        
        switch(status) {
            case 'saving':
                indicator.classList.add('saving');
                text.textContent = 'Saving...';
                text.classList.add('text-yellow-600');
                break;
            case 'saved':
                indicator.classList.add('saved');
                text.textContent = 'Saved';
                text.classList.add('text-green-600');
                lastSaveTime = new Date();
                document.getElementById('lastSaved').textContent = 
                    `Last saved: ${lastSaveTime.toLocaleTimeString()}`;
               
                const autoSaveStatus = document.getElementById('autoSaveStatus');
                autoSaveStatus.classList.remove('hidden');
                setTimeout(() => {
                    autoSaveStatus.classList.add('hidden');
                }, 3000);
                break;
            case 'error':
                indicator.classList.add('error');
                text.textContent = 'Save failed';
                text.classList.add('text-red-600');
                break;
            default:
                indicator.classList.add('bg-gray-400');
                text.textContent = 'Idle';
                text.classList.add('text-gray-700');
        }
    }

    function saveDraft() {
        if (!formChanged) return;
        
        updateAutoSaveStatus('saving');
        
        const data = getFormData();
        
        localStorage.setItem('resumeDraft', JSON.stringify(data));
        localStorage.setItem('resumeDraftTimestamp', new Date().toISOString());
        
        fetch('<?php echo e(route("resume.save")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                updateAutoSaveStatus('saved');
                formChanged = false;
            } else {
                updateAutoSaveStatus('error');
            }
        })
        .catch(error => {
            updateAutoSaveStatus('error');
            console.error('Auto-save failed:', error);
        });
    }

    function clearDraft() {
        if (confirm('Are you sure you want to clear your current draft?')) {
            localStorage.removeItem('resumeDraft');
            localStorage.removeItem('resumeDraftTimestamp');
            document.getElementById('resumeForm').reset();
            
            employmentCounter = 0;
            educationCounter = 0;
            languageCounter = 0;
            skillCounter = 0;
            
            document.getElementById('employmentContainer').innerHTML = '';
            document.getElementById('educationContainer').innerHTML = '';
            document.getElementById('languageContainer').innerHTML = '';
            document.getElementById('skillsContainer').innerHTML = '';
            
            document.getElementById('selectedTemplate').value = '';
            document.getElementById('templatePreviewInfo').classList.add('hidden');
            
            addEmployment();
            addEducation();
            addLanguage();
            addSkill();
            
            formChanged = false;
            updateProgress();
            refreshPreview();
            showMessage('Draft cleared successfully!', 'success');
        }
    }

    function loadDraft() {
        const draft = localStorage.getItem('resumeDraft');
        const timestamp = localStorage.getItem('resumeDraftTimestamp');
        
        if (draft) {
            const data = JSON.parse(draft);
            
            const draftDate = new Date(timestamp);
            const now = new Date();
            const daysDiff = (now - draftDate) / (1000 * 60 * 60 * 24);
            
            if (daysDiff < 7) {
                if (confirm(`Would you like to load your saved draft from ${draftDate.toLocaleDateString()}?`)) {
                    populateForm(data);
                    showMessage('Draft loaded successfully!', 'success');
                }
            } else {
                if (daysDiff < 1) {
                    populateForm(data);
                    showMessage('Auto-loaded recent draft', 'info');
                }
            }
        }
    }

    function populateForm(data) {
        document.getElementById('employmentContainer').innerHTML = '';
        document.getElementById('educationContainer').innerHTML = '';
        document.getElementById('languageContainer').innerHTML = '';
        document.getElementById('skillsContainer').innerHTML = '';
        
        employmentCounter = 0;
        educationCounter = 0;
        languageCounter = 0;
        skillCounter = 0;
        
        Object.keys(data).forEach(key => {
            if (Array.isArray(data[key])) {
                if (key === 'job_title' || key === 'company' || key === 'job_start' || key === 'job_end' || key === 'job_description') {
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('employmentContainer').children.length) {
                            addEmployment();
                        }
                    });
                } else if (key === 'degree' || key === 'school' || key === 'edu_start' || key === 'edu_end' || key === 'edu_description') {
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('educationContainer').children.length) {
                            addEducation();
                        }
                    });
                } else if (key === 'languages' || key === 'language_level') {
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('languageContainer').children.length) {
                            addLanguage();
                        }
                    });
                } else if (key === 'skills' || key === 'skill_level') {
                    data[key].forEach((value, index) => {
                        if (index >= document.getElementById('skillsContainer').children.length) {
                            addSkill();
                        }
                    });
                }
                
                setTimeout(() => {
                    data[key].forEach((value, index) => {
                        const baseName = key.endsWith('[]') ? key.slice(0, -2) : key;
                        const elements = document.querySelectorAll(`[name="${baseName}[]"]`);
                        if (elements[index]) {
                            elements[index].value = value;
                        }
                    });
                    updateProgress();
                    refreshPreview();
                }, 100);
            } else {
                const element = document.querySelector(`[name="${key}"]`);
                if (element) {
                    element.value = data[key];
                }
            }
        });
        
        if (data.phone && phoneInput) {
            phoneInput.setNumber(data.phone);
        }
        
        if (data.template) {
            document.getElementById('selectedTemplate').value = data.template;
            
            const templateNames = {
                'template1': 'Professional Blue',
                'template2': 'Modern Black',
                'template3': 'Creative Green'
            }
            const templateDescriptions = {
                'template1': 'Clean and professional design with blue accents, perfect for corporate environments.',
                'template2': 'Contemporary design with dark accents and clean lines for modern industries.',
                'template3': 'Fresh and creative design with green theme for design and marketing fields.'
            };
            
            document.getElementById('currentTemplateName').textContent = templateNames[data.template];
            document.getElementById('templateDescription').textContent = templateDescriptions[data.template];
            document.getElementById('templatePreviewInfo').classList.remove('hidden');
        }
        
        updateProgress();
        refreshPreview();
    }

    function toggleAdditional() {
        const section = document.getElementById('additionalDetails');
        const icon = document.getElementById('additionalIcon');
        const text = document.getElementById('additionalText');
        
        section.classList.toggle('hidden');
        if (section.classList.contains('hidden')) {
            icon.textContent = '+';
            text.textContent = 'Show Additional Details';
        } else {
            icon.textContent = '-';
            text.textContent = 'Hide Additional Details';
        }
        updateProgress();
        refreshPreview();
    }

    const debouncedPreviewUpdate = debounce(refreshPreview, 1000);

    function refreshPreview() {
        const data = getFormData();
        const template = document.getElementById('selectedTemplate').value;
        
        if (!template) {
            document.getElementById('livePreview').innerHTML = `
                <div class="text-center text-gray-500">
                    <div class="text-6xl mb-4">📝</div>
                    <p class="text-xl font-semibold mb-2">Please select a template</p>
                    <p class="text-gray-600">Choose a template to see your resume preview</p>
                </div>
            `;
            return;
        }
        
        fetch('<?php echo e(route("resume.preview")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const styles = doc.querySelectorAll('style');
            let styleContent = '';
            styles.forEach(style => {
                styleContent += style.textContent;
            });
            const bodyContent = doc.body.innerHTML;
            const wrappedContent = `<div class="template-content">${bodyContent}</div>`;
            const scopedStyles = scopeCss(styleContent, '.template-content');
            document.getElementById('livePreview').innerHTML = wrappedContent;
            const existingStyle = document.getElementById('livePreviewStyle');
            if (existingStyle) {
                existingStyle.remove();
            }
            const styleTag = document.createElement('style');
            styleTag.id = 'livePreviewStyle';
            styleTag.textContent = scopedStyles;
            document.getElementById('livePreview').appendChild(styleTag);
            
            document.getElementById('livePreview').classList.add('fade-in');
        })
        .catch(error => {
            console.error('Preview update failed:', error);
        });
    }

 function updateProgress() {
    const inputs = document.querySelectorAll('input, textarea, select');
    let filled = 0, total = 0;
    
    inputs.forEach(i => {
        if (i.offsetParent !== null && i.classList.contains('required-field')) {
            total++;
            if (i.type === 'select-one') {
                if (i.value !== '') filled++;
            } else if (i.type === 'tel') {
                if (phoneInput.isValidNumber()) filled++;
            } else {
                if (i.value.trim() !== '') filled++;
            }
        }
    });
    
    const percent = Math.round((filled / total) * 100);
    const progressBar = document.getElementById('progressBar');
    
    // Sirf width update karen, color change nahi karenge
    progressBar.style.width = percent + '%';
    document.getElementById('progressText').innerText = percent + '% Complete';
}

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function showMessage(message, type = 'info') {
        const container = document.getElementById('messageContainer');
        const colors = {
            success: 'bg-green-100 border-green-400 text-green-700',
            error: 'bg-red-100 border-red-400 text-red-700',
            info: 'bg-blue-100 border-blue-400 text-blue-700'
        };
        
        container.className = `${colors[type]} border-l-4 p-4 rounded-xl`;
        container.innerHTML = message;
        container.classList.remove('hidden');
        
        setTimeout(() => {
            container.classList.add('hidden');
        }, 5000);
    }

    function validateForm() {
        let isValid = true;
        const requiredFields = document.querySelectorAll('.required-field');
        let emptyFields = [];

        requiredFields.forEach(field => {
            if (field.type === 'select-one') {
                if (field.value === '') {
                    isValid = false;
                    emptyFields.push(field.name || field.previousElementSibling?.textContent || 'Field');
                }
            } else if (field.type === 'tel') {
                if (!phoneInput.isValidNumber()) {
                    isValid = false;
                    emptyFields.push('Phone Number');
                }
            } else {
                if (field.value.trim() === '') {
                    isValid = false;
                    emptyFields.push(field.name || field.previousElementSibling?.textContent || 'Field');
                }
            }
        });

        if (!isValid) {
            showMessage(`Please fill all required fields before downloading. Missing: ${emptyFields.slice(0, 3).join(', ')}${emptyFields.length > 3 ? '...' : ''}`, 'error');
            return;
        }

        const selectedTemplate = document.getElementById('selectedTemplate').value;
        if (!selectedTemplate) {
            showMessage('Please select a template before downloading.', 'error');
            return;
        }

        if (phoneInput.isValidNumber()) {
            document.getElementById('fullPhone').value = phoneInput.getNumber();
        }

        showMessage('Generating your resume PDF...', 'info');
        document.getElementById('resumeForm').submit();
    }

    function addEmployment() {
        const container = document.getElementById('employmentContainer');
        employmentCounter++;
        const index = employmentCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl employment-item bg-gray-50">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-gray-700 text-lg">Job #${index}</h4>
                    <button type="button" onclick="removeEmployment(this)" class="text-red-500 hover:text-red-700 font-medium">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Job Title</label>
                        <input type="text" name="job_title[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Company</label>
                        <input type="text" name="company[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Start Date</label>
                        <input type="month" name="job_start[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">End Date</label>
                        <input type="month" name="job_end[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Job Description and Responsibilities</label>
                    <textarea name="job_description[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()" rows="3"></textarea>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeEmployment(button) {
        button.closest('.employment-item').remove();
        updateProgress();
        refreshPreview();
    }

    function addEducation() {
        const container = document.getElementById('educationContainer');
        educationCounter++;
        const index = educationCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl education-item bg-gray-50">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-gray-700 text-lg">Education #${index}</h4>
                    <button type="button" onclick="removeEducation(this)" class="text-red-500 hover:text-red-700 font-medium">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Degree/Certificate</label>
                        <input type="text" name="degree[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">School/University</label>
                        <input type="text" name="school[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Start Date</label>
                        <input type="month" name="edu_start[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">End Date</label>
                        <input type="month" name="edu_end[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Description of Studies</label>
                    <textarea name="edu_description[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()" rows="3"></textarea>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeEducation(button) {
        button.closest('.education-item').remove();
        updateProgress();
        refreshPreview();
    }

    function addLanguage() {
        const container = document.getElementById('languageContainer');
        languageCounter++;
        const index = languageCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl language-item bg-gray-50">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-gray-700 text-lg">Language #${index}</h4>
                    <button type="button" onclick="removeLanguage(this)" class="text-red-500 hover:text-red-700 font-medium">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Language</label>
                        <select name="languages[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                            <option value="">Select Language</option>
                             <?php echo $__env->make('partials.language-options', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Proficiency</label>
                        <select name="language_level[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                            <option value="">Select Proficiency</option>
                            <option value="Native">Native</option>
                            <option value="Fluent">Fluent</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Basic">Basic</option>
                        </select>
                    </div>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeLanguage(button) {
        button.closest('.language-item').remove();
        updateProgress();
        refreshPreview();
    }

    function addSkill() {
        const container = document.getElementById('skillsContainer');
        skillCounter++;
        const index = skillCounter;
        
        container.insertAdjacentHTML('beforeend', `
            <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl skill-item bg-gray-50">
                <div class="flex justify-between items-center">
                    <h4 class="font-bold text-gray-700 text-lg">Skill #${index}</h4>
                    <button type="button" onclick="removeSkill(this)" class="text-red-500 hover:text-red-700 font-medium">
                        Remove
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Skill</label>
                        <input type="text" name="skills[]" placeholder="e.g., JavaScript, Project Management" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" oninput="handleInputChange()">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Level</label>
                        <select name="skill_level[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field" onchange="handleInputChange()">
                            <option value="">Select Level</option>
                            <option value="Expert">Expert</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Beginner">Beginner</option>
                        </select>
                    </div>
                </div>
            </div>
        `);
        updateProgress();
    }

    function removeSkill(button) {
        button.closest('.skill-item').remove();
        updateProgress();
        refreshPreview();
    }
    function scopeCss(css, scope) {
        let scopedCss = '';
        const rules = css.split('}');
        rules.forEach(rule => {
            if (rule.trim() === '') return;
            if (rule.startsWith('@')) {
                const parts = rule.split('{');
                if (parts.length === 2) {
                    scopedCss += parts[0] + '{' + scopeCss(parts[1], scope) + '}';
                } else {
                    scopedCss += rule + '}';
                }
            } else {
                const parts = rule.split('{');
                if (parts.length === 2) {
                    const selectors = parts[0].split(',').map(selector => {
                        return scope + ' ' + selector.trim();
                    }).join(', ');
                    scopedCss += selectors + '{' + parts[1] + '}';
                } else {
                    scopedCss += rule + '}';
                }
            }
        });
        
        return scopedCss;
    }

  </script>
</body>
</html><?php /**PATH C:\laragon\www\resume2\resources\views/resume.blade.php ENDPATH**/ ?>
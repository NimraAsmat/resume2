<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resume Builder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
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
    
   
    .custom-select {
      background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0ibTcgNyA1IDUgNS01IiBzdHJva2U9IiM2QjcyODAiIHN0cm9rZS13aWR0aD0iMS41IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+');
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 16px 16px;
      padding-right: 2.5rem !important;
    }
    
    
    select {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }

   
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }


    .validation-valid {
      border-color: #10b981 !important;
    }

    .validation-invalid {
      border-color: #ef4444 !important;
    }

    .validation-normal {
      border-color: #93c5fd !important;
    }
  </style>
</head>
<body class="bg-gray-50 font-sans">
<header class="text-black">
    <div class="max-w-8xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">

            
            <div class="flex-1 text-center">
                <h1 class="text-4xl font-bold text-black">
                    ResumeBuilder Pro
                </h1>
                <p class="text-black/60 text-sm hidden sm:block">Professional Resume Creator</p>
            </div>

            
            <div class="relative group" id="userMenu">
                <button class="flex items-center space-x-3 transition-all duration-200">
                    <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center shadow-md">
                        <span class="text-white font-semibold text-lg uppercase">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </span>
                    </div>
                </button>

               
                <div class="absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible 
                    group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 z-50">

                  
                    <div class="p-4 border-b border-gray-200">
                        <p class="text-gray-900 font-semibold text-sm truncate">
                            {{ ucfirst(Auth::user()->name ?? 'User') }}
                        </p>
                        <p class="text-gray-600 text-xs truncate">
                            {{ Auth::user()->email ?? '' }}
                        </p>
                    </div>

                   
                    <div class="p-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200">
                                <i class="fas fa-sign-out-alt text-sm mr-2"></i>
                                <span class="font-medium text-sm">Sign Out</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</header>

<main class="max-w-8xl mx-auto mt-8 p-6">
    
    <div id="formPage" class="transition-all duration-300 ease-in-out">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        
        
        <div class="bg-white shadow-xl rounded-2xl p-8 lg:col-span-3">
        
          <div class="bg-white p-6 rounded-xl shadow-sm mb-6 border border-gray-100">
            <div class="flex justify-between items-center">
              <div class="flex items-center space-x-4">
                <div id="autoSaveIndicator" class="w-3 h-3 bg-gray-400 rounded-full transition-all duration-300"></div>
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

          <form method="POST" action="{{ route('resume.download') }}" id="resumeForm" novalidate>
            @csrf
            <input type="hidden" name="template" id="selectedTemplate" value="">
            <input type="hidden" name="phone" id="fullPhone">

            
            <section class="space-y-6 mb-8">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Personal Details</h3>
                <p class="text-gray-600 text-sm">Enter your basic personal information, such as your name, contact details, and nationality.</p>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">First Name</label>
                  <input type="text" name="first_name" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="name">
                  <span class="text-red-500 text-xs mt-1 hidden" id="first_name_error"></span>
                </div>
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Last Name</label>
                  <input type="text" name="last_name" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="name">
                  <span class="text-red-500 text-xs mt-1 hidden" id="last_name_error"></span>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                  <input type="email" name="email" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="email">
                  <span class="text-red-500 text-xs mt-1 hidden" id="email_error"></span>
                </div>
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Phone Number</label>
                  <div class="relative">
                    <input type="tel" id="phone" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validatePhoneField()">
                    <span class="text-red-500 text-xs mt-1 hidden" id="phone_error"></span>
                  </div>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Occupation</label>
                  <input type="text" name="occupation" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
                  <span class="text-red-500 text-xs mt-1 hidden" id="occupation_error"></span>
                </div>
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Country</label>
                  <select name="country" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                    <option value="">Select Country</option>
                    @include('partials.country-options')
                  </select>
                  <span class="text-red-500 text-xs mt-1 hidden" id="country_error"></span>
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Date of Birth</label>
                  <input type="date" name="dob" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" onchange="validateField(this)" data-validation="date">
                  <span class="text-red-500 text-xs mt-1 hidden" id="dob_error"></span>
                </div>
                <div class="mb-4">
                  <label class="block text-sm font-semibold text-gray-800 mb-2">Nationality</label>
                  <select name="nationality" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                    <option value="">Select Nationality</option>
                    @include('partials.nationality-options')
                  </select>
                  <span class="text-red-500 text-xs mt-1 hidden" id="nationality_error"></span>
                </div>
              </div>
              
              <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Gender</label>
                <select name="gender" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                  <option value="Prefer not to say">Prefer not to say</option>
                </select>
                <span class="text-red-500 text-xs mt-1 hidden" id="gender_error"></span>
              </div>
            </section>

            <section id="additionalDetails" class="space-y-6 mt-8 hidden">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Additional Details</h3>
                <p class="text-gray-600 text-sm">Include hobbies, interests, or personal achievements.</p>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Hobbies</label>
                <textarea name="hobbies" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 additional-field validation-normal" placeholder="e.g., Reading, Traveling, Photography" oninput="validateField(this)" data-validation="textarea" rows="3"></textarea>
                <span class="text-red-500 text-xs mt-1 hidden" id="hobbies_error"></span>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Interests</label>
                <textarea name="interests" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 additional-field validation-normal" placeholder="e.g., AI Technology, Environmental Conservation" oninput="validateField(this)" data-validation="textarea" rows="3"></textarea>
                <span class="text-red-500 text-xs mt-1 hidden" id="interests_error"></span>
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
              <div class="mb-4">
                <textarea name="summary" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" placeholder="Enter your professional summary..." oninput="validateField(this)" data-validation="textarea" rows="5"></textarea>
                <span class="text-red-500 text-xs mt-1 hidden" id="summary_error"></span>
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

        <!-- Preview Section - 40% width -->
        <div class="bg-white shadow-xl rounded-2xl p-8 sticky top-8 lg:col-span-2">
          <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span>Live Preview</span>
            <span id="autoSaveStatus" class="ml-3 text-xs bg-green-100 text-green-800 px-3 py-1.5 rounded-full font-medium hidden">
              Auto-saved
            </span>
          </h3>
          
          <div id="livePreview" class="border-2 border-dashed border-gray-300 rounded-2xl p-8 min-h-[600px] flex items-center justify-center transition-all duration-300 ease-in-out">
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
            
            <button type="button" onclick="validateAndDownload()" class="px-8 py-4 font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
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

    <div id="templatePage" class="transition-all duration-300 ease-in-out hidden">
      
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

    
    const validationRules = {
      name: {
        pattern: /^[A-Za-z\s\-']{2,50}$/,
        message: "Please enter a valid name (2-50 characters, letters only)"
      },
      email: {
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        message: "Please enter a valid email address"
      },
      text: {
        pattern: /^.{2,100}$/,
        message: "This field must be between 2-100 characters"
      },
      textarea: {
        pattern: /^.{10,2000}$/,
        message: "This field must be between 10-2000 characters"
      },
      select: {
        pattern: /.+/,
        message: "Please select an option"
      },
      date: {
        pattern: /^(?:\d{4}-\d{2}-\d{2})?$/,
        message: "Please enter a valid date"
      },
      phone: {
        pattern: /^\+?[\d\s\-\(\)]{10,}$/,
        message: "Please enter a valid phone number"
      },
      month: {
        pattern: /^(?:\d{4}-\d{2})?$/,
        message: "Please enter date in YYYY-MM format"
      }
    };

    
    function validateField(field) {
      const fieldName = field.name;
      const fieldValue = field.value.trim();
      const validationType = field.getAttribute('data-validation');
      const errorElement = document.getElementById(`${fieldName}_error`);
      
      
      field.classList.remove('validation-valid', 'validation-invalid', 'validation-normal');
      
      
      if (fieldName.includes('[]') && fieldValue === '') {
        if (errorElement) {
          errorElement.textContent = '';
          errorElement.classList.add('hidden');
        }
        field.classList.add('validation-normal');
        return true;
      }
      
      
      if (!field.classList.contains('required-field') && fieldValue === '') {
        if (errorElement) {
          errorElement.textContent = '';
          errorElement.classList.add('hidden');
        }
        field.classList.add('validation-normal');
        return true;
      }
      
    
      let isValid = false;
      let errorMessage = '';
      
      switch(validationType) {
        case 'name':
          isValid = validationRules.name.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.name.message;
          break;
          
        case 'email':
          isValid = validationRules.email.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.email.message;
          break;
          
        case 'text':
          isValid = validationRules.text.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.text.message;
          break;
          
        case 'textarea':
          isValid = validationRules.textarea.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.textarea.message;
          break;
          
        case 'select':
          isValid = validationRules.select.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.select.message;
          break;
          
        case 'date':
          isValid = fieldValue === '' || validationRules.date.pattern.test(fieldValue);
          if (fieldValue) {
            const inputDate = new Date(fieldValue);
            const today = new Date();
            isValid = inputDate <= today;
            errorMessage = isValid ? '' : 'Date cannot be in the future';
          }
          break;
          
        case 'month':
          isValid = validationRules.month.pattern.test(fieldValue);
          errorMessage = isValid ? '' : validationRules.month.message;
          break;
          
        default:
          isValid = fieldValue !== '';
          errorMessage = isValid ? '' : 'This field is required';
      }
      
      
      if (fieldValue !== '') {
        if (isValid) {
          field.classList.add('validation-valid');
        } else {
          field.classList.add('validation-invalid');
        }
      } else {
        field.classList.add('validation-normal');
      }
      
      
      if (errorElement) {
        if (errorMessage) {
          errorElement.textContent = errorMessage;
          errorElement.classList.remove('hidden');
        } else {
          errorElement.textContent = '';
          errorElement.classList.add('hidden');
        }
      }
      
      handleInputChange();
      return isValid;
    }

    function validatePhoneField() {
      const phoneField = document.getElementById('phone');
      const errorElement = document.getElementById('phone_error');
      
      phoneField.classList.remove('validation-valid', 'validation-invalid', 'validation-normal');
      
      if (phoneInput.isValidNumber()) {
        phoneField.classList.add('validation-valid');
        document.getElementById('fullPhone').value = phoneInput.getNumber();
        if (errorElement) {
          errorElement.textContent = '';
          errorElement.classList.add('hidden');
        }
        return true;
      } else {
        phoneField.classList.add('validation-invalid');
        if (errorElement) {
          errorElement.textContent = 'Please enter a valid phone number';
          errorElement.classList.remove('hidden');
        }
        return false;
      }
    }

   
    function validateAllFields() {
      let isValid = true;
      const fields = document.querySelectorAll('[data-validation]');
      
      
      fields.forEach(field => {
        field.classList.remove('validation-invalid', 'validation-valid');
        field.classList.add('validation-normal');
      });
      
      
      fields.forEach(field => {
        if (field.classList.contains('required-field') || field.value.trim() !== '') {
          if (!validateField(field)) {
            isValid = false;
          }
        }
      });
      
  
      if (!validatePhoneField()) {
        isValid = false;
      }
      
      
      if (!validateDynamicSections()) {
        isValid = false;
      }
      
      return isValid;
    }

    
    function validateLanguagePair(languageField, levelField, index) {
      let isValid = true;
      
      const languageValue = languageField.value.trim();
      const levelValue = levelField.value.trim();
      
     
      languageField.classList.remove('validation-invalid', 'validation-valid', 'validation-normal');
      levelField.classList.remove('validation-invalid', 'validation-valid', 'validation-normal');
      
   
      if (languageValue === '' && levelValue === '') {
        languageField.classList.add('validation-normal');
        levelField.classList.add('validation-normal');
        return true;
      }
      
      
      if (languageValue === '' || levelValue === '') {
        isValid = false;
        
        if (languageValue === '') {
          languageField.classList.add('validation-invalid');
          
          const errorId = `languages_${index}_error`;
          let errorElement = document.getElementById(errorId);
          if (!errorElement) {
            const parentDiv = languageField.closest('.mb-4');
            if (parentDiv) {
              errorElement = document.createElement('span');
              errorElement.id = errorId;
              errorElement.className = 'text-red-500 text-xs mt-1';
              parentDiv.appendChild(errorElement);
            }
          }
          if (errorElement) {
            errorElement.textContent = 'Language is required when proficiency is selected';
            errorElement.classList.remove('hidden');
          }
        }
        
        if (levelValue === '') {
          levelField.classList.add('validation-invalid');
          
          const errorId = `language_level_${index}_error`;
          let errorElement = document.getElementById(errorId);
          if (!errorElement) {
            const parentDiv = levelField.closest('.mb-4');
            if (parentDiv) {
              errorElement = document.createElement('span');
              errorElement.id = errorId;
              errorElement.className = 'text-red-500 text-xs mt-1';
              parentDiv.appendChild(errorElement);
            }
          }
          if (errorElement) {
            errorElement.textContent = 'Proficiency is required when language is selected';
            errorElement.classList.remove('hidden');
          }
        }
      } else {
        // Both fields are filled - mark as valid
        languageField.classList.add('validation-valid');
        levelField.classList.add('validation-valid');
        
        // Clear error messages
        const languageErrorId = `languages_${index}_error`;
        const levelErrorId = `language_level_${index}_error`;
        const languageErrorElement = document.getElementById(languageErrorId);
        const levelErrorElement = document.getElementById(levelErrorId);
        
        if (languageErrorElement) {
          languageErrorElement.textContent = '';
          languageErrorElement.classList.add('hidden');
        }
        if (levelErrorElement) {
          levelErrorElement.textContent = '';
          levelErrorElement.classList.add('hidden');
        }
      }
      
      return isValid;
    }

  
    function validateDynamicSections() {
      let isValid = true;
      
      
      const jobTitles = document.querySelectorAll('input[name="job_title[]"]');
      const hasEmploymentData = Array.from(jobTitles).some(field => field.value.trim() !== '');
      
      if (hasEmploymentData) {
        jobTitles.forEach((field, index) => {
          if (field.value.trim() === '') {
            isValid = false;
            field.classList.remove('validation-valid', 'validation-normal');
            field.classList.add('validation-invalid');
            
            const errorId = `job_title_${index}_error`;
            let errorElement = document.getElementById(errorId);
            if (!errorElement) {
              const parentDiv = field.closest('.mb-4');
              if (parentDiv) {
                errorElement = document.createElement('span');
                errorElement.id = errorId;
                errorElement.className = 'text-red-500 text-xs mt-1';
                parentDiv.appendChild(errorElement);
              }
            }
            if (errorElement) {
              errorElement.textContent = 'Job title is required';
              errorElement.classList.remove('hidden');
            }
          } else {
            const errorId = `job_title_${index}_error`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
              errorElement.textContent = '';
              errorElement.classList.add('hidden');
            }
            field.classList.remove('validation-invalid');
            field.classList.add('validation-valid');
          }
        });
      }
      
      
      const degrees = document.querySelectorAll('input[name="degree[]"]');
      const hasEducationData = Array.from(degrees).some(field => field.value.trim() !== '');
      
      if (hasEducationData) {
        degrees.forEach((field, index) => {
          if (field.value.trim() === '') {
            isValid = false;
            field.classList.remove('validation-valid', 'validation-normal');
            field.classList.add('validation-invalid');
            
            const errorId = `degree_${index}_error`;
            let errorElement = document.getElementById(errorId);
            if (!errorElement) {
              const parentDiv = field.closest('.mb-4');
              if (parentDiv) {
                errorElement = document.createElement('span');
                errorElement.id = errorId;
                errorElement.className = 'text-red-500 text-xs mt-1';
                parentDiv.appendChild(errorElement);
              }
            }
            if (errorElement) {
              errorElement.textContent = 'Degree is required';
              errorElement.classList.remove('hidden');
            }
          } else {
            const errorId = `degree_${index}_error`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
              errorElement.textContent = '';
              errorElement.classList.add('hidden');
            }
            field.classList.remove('validation-invalid');
            field.classList.add('validation-valid');
          }
        });
      }
      
    
      const languageFields = document.querySelectorAll('select[name="languages[]"]');
      const levelFields = document.querySelectorAll('select[name="language_level[]"]');
      
      languageFields.forEach((languageField, index) => {
        const levelField = levelFields[index];
        if (languageField && levelField) {
          if (!validateLanguagePair(languageField, levelField, index)) {
            isValid = false;
          }
        }
      });
      
      
      const skillFields = document.querySelectorAll('input[name="skills[]"]');
      const skillLevelFields = document.querySelectorAll('select[name="skill_level[]"]');
      
      skillFields.forEach((skillField, index) => {
        const levelField = skillLevelFields[index];
        
        
        skillField.classList.remove('validation-invalid', 'validation-valid', 'validation-normal');
        levelField.classList.remove('validation-invalid', 'validation-valid', 'validation-normal');
        
      
        if (skillField.value.trim() === '' && levelField.value.trim() === '') {
          skillField.classList.add('validation-normal');
          levelField.classList.add('validation-normal');
          return;
        }
        
        
        if (skillField.value.trim() === '' || levelField.value.trim() === '') {
          isValid = false;
          
          if (skillField.value.trim() === '') {
            skillField.classList.add('validation-invalid');
            
            const errorId = `skills_${index}_error`;
            let errorElement = document.getElementById(errorId);
            if (!errorElement) {
              const parentDiv = skillField.closest('.mb-4');
              if (parentDiv) {
                errorElement = document.createElement('span');
                errorElement.id = errorId;
                errorElement.className = 'text-red-500 text-xs mt-1';
                parentDiv.appendChild(errorElement);
              }
            }
            if (errorElement) {
              errorElement.textContent = 'Skill is required when level is selected';
              errorElement.classList.remove('hidden');
            }
          }
          
          if (levelField.value.trim() === '') {
            levelField.classList.add('validation-invalid');
            
            const errorId = `skill_level_${index}_error`;
            let errorElement = document.getElementById(errorId);
            if (!errorElement) {
              const parentDiv = levelField.closest('.mb-4');
              if (parentDiv) {
                errorElement = document.createElement('span');
                errorElement.id = errorId;
                errorElement.className = 'text-red-500 text-xs mt-1';
                parentDiv.appendChild(errorElement);
              }
            }
            if (errorElement) {
              errorElement.textContent = 'Skill level is required when skill is entered';
              errorElement.classList.remove('hidden');
            }
          }
        } else {
          
          skillField.classList.add('validation-valid');
          levelField.classList.add('validation-valid');
          
          
          const skillErrorId = `skills_${index}_error`;
          const levelErrorId = `skill_level_${index}_error`;
          const skillErrorElement = document.getElementById(skillErrorId);
          const levelErrorElement = document.getElementById(levelErrorId);
          
          if (skillErrorElement) {
            skillErrorElement.textContent = '';
            skillErrorElement.classList.add('hidden');
          }
          if (levelErrorElement) {
            levelErrorElement.textContent = '';
            levelErrorElement.classList.add('hidden');
          }
        }
      });
      
      return isValid;
    }

 
    function isMonthInputSupported() {
      try {
        const input = document.createElement('input');
        input.setAttribute('type', 'month');
        return input.type === 'month';
      } catch (e) {
        return false;
      }
    }

    
    function createUniversalDateInput(name, placeholder = 'YYYY-MM') {
      const supportsMonth = isMonthInputSupported();
      
      if (supportsMonth) {
      
        return `
          <input type="month" 
                 name="${name}" 
                 class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" 
                 oninput="validateField(this)" 
                 data-validation="month"
                 title="Select month and year">
        `;
      } else {
       
        return `
          <input type="text" 
                 name="${name}" 
                 class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" 
                 placeholder="${placeholder}"
                 pattern="[0-9]{4}-[0-9]{2}"
                 title="Please enter date in YYYY-MM format (e.g., 2023-12)"
                 oninput="handleUniversalDateInput(this)"
                 data-validation="month"
                 maxlength="7">
        `;
      }
    }

   
    function handleUniversalDateInput(input) {
      let value = input.value.replace(/[^0-9-]/g, '');
      
      
      if (value.length > 7) {
        value = value.slice(0, 7);
      }
      
      
      if (value.length === 4 && !value.includes('-')) {
        value += '-';
      }
      
      input.value = value;
      validateField(input);
    }

    
    function addEmployment() {
      const container = document.getElementById('employmentContainer');
      employmentCounter++;
      const index = employmentCounter;
      
    
      const startDateInput = createUniversalDateInput('job_start[]');
      const endDateInput = createUniversalDateInput('job_end[]');
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl employment-item bg-gray-50">
          <div class="flex justify-between items-center">
            <h4 class="font-bold text-gray-700 text-lg">Job #${index}</h4>
            <button type="button" onclick="removeEmployment(this)" class="text-red-500 hover:text-red-700 font-medium">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Job Title</label>
              <input type="text" name="job_title[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
              <span class="text-red-500 text-xs mt-1 hidden" id="job_title_${index}_error"></span>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Company</label>
              <input type="text" name="company[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
              <span class="text-red-500 text-xs mt-1 hidden" id="company_${index}_error"></span>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Start Date</label>
              ${startDateInput}
              <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM (e.g., 2020-01)</p>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">End Date</label>
              ${endDateInput}
              <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM (e.g., 2023-12)</p>
            </div>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-800 mb-2">Job Description and Responsibilities</label>
            <textarea name="job_description[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="textarea" rows="3"></textarea>
            <span class="text-red-500 text-xs mt-1 hidden" id="job_description_${index}_error"></span>
          </div>
        </div>
      `);
      updateProgress();
    }

   
    function addEducation() {
      const container = document.getElementById('educationContainer');
      educationCounter++;
      const index = educationCounter;
      
      
      const startDateInput = createUniversalDateInput('edu_start[]');
      const endDateInput = createUniversalDateInput('edu_end[]');
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-4 mt-6 p-6 border border-gray-200 rounded-xl education-item bg-gray-50">
          <div class="flex justify-between items-center">
            <h4 class="font-bold text-gray-700 text-lg">Education #${index}</h4>
            <button type="button" onclick="removeEducation(this)" class="text-red-500 hover:text-red-700 font-medium">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Degree/Certificate</label>
              <input type="text" name="degree[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
              <span class="text-red-500 text-xs mt-1 hidden" id="degree_${index}_error"></span>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">School/University</label>
              <input type="text" name="school[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
              <span class="text-red-500 text-xs mt-1 hidden" id="school_${index}_error"></span>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Start Date</label>
              ${startDateInput}
              <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM (e.g., 2018-09)</p>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">End Date</label>
              ${endDateInput}
              <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM (e.g., 2022-05)</p>
            </div>
          </div>
          <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-800 mb-2">Description of Studies</label>
            <textarea name="edu_description[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="textarea" rows="3"></textarea>
            <span class="text-red-500 text-xs mt-1 hidden" id="edu_description_${index}_error"></span>
          </div>
        </div>
      `);
      updateProgress();
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
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Language</label>
              <select name="languages[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                <option value="">Select Language</option>
                @include('partials.language-options')
              </select>
              <span class="text-red-500 text-xs mt-1 hidden" id="languages_${index}_error"></span>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Proficiency</label>
              <select name="language_level[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                <option value="">Select Proficiency</option>
                <option value="Native">Native</option>
                <option value="Fluent">Fluent</option>
                <option value="Advanced">Advanced</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Basic">Basic</option>
              </select>
              <span class="text-red-500 text-xs mt-1 hidden" id="language_level_${index}_error"></span>
            </div>
          </div>
        </div>
      `);
      updateProgress();
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
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Skill</label>
              <input type="text" name="skills[]" placeholder="e.g., JavaScript, Project Management" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 required-field validation-normal" oninput="validateField(this)" data-validation="text">
              <span class="text-red-500 text-xs mt-1 hidden" id="skills_${index}_error"></span>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-semibold text-gray-800 mb-2">Level</label>
              <select name="skill_level[]" class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 cursor-pointer custom-select required-field validation-normal" onchange="validateField(this)" data-validation="select">
                <option value="">Select Level</option>
                <option value="Expert">Expert</option>
                <option value="Advanced">Advanced</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Beginner">Beginner</option>
              </select>
              <span class="text-red-500 text-xs mt-1 hidden" id="skill_level_${index}_error"></span>
            </div>
          </div>
        </div>
      `);
      updateProgress();
    }

    
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

      
        console.log('Browser month input support:', isMonthInputSupported() ? 'Supported' : 'Not Supported - Using Fallback');
    });

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
            validatePhoneField();
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
        
        indicator.className = 'w-3 h-3 rounded-full transition-all duration-300';
        text.className = 'text-sm font-semibold';
        
        switch(status) {
            case 'saving':
                indicator.classList.add('bg-yellow-500', 'animate-pulse');
                text.textContent = 'Saving...';
                text.classList.add('text-yellow-600');
                break;
            case 'saved':
                indicator.classList.add('bg-green-500');
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
                indicator.classList.add('bg-red-500');
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
        
        fetch('{{ route("resume.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            
           
            document.querySelectorAll('input, textarea, select').forEach(el => {
                el.classList.remove('validation-valid', 'validation-invalid');
                el.classList.add('validation-normal');
            });
            
            document.querySelectorAll('.text-red-500').forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });
            
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
                            validateField(elements[index]);
                        }
                    });
                    updateProgress();
                    refreshPreview();
                }, 100);
            } else {
                const element = document.querySelector(`[name="${key}"]`);
                if (element) {
                    element.value = data[key];
                    validateField(element);
                }
            }
        });
        
        if (data.phone && phoneInput) {
            phoneInput.setNumber(data.phone);
            validatePhoneField();
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
        
        fetch('{{ route("resume.preview") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            
            document.getElementById('livePreview').classList.add('opacity-0');
            setTimeout(() => {
                document.getElementById('livePreview').classList.remove('opacity-0');
            }, 10);
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

   
    function validateAndDownload() {
        console.log('=== DOWNLOAD PROCESS STARTED ===');
        
       
        saveDraft();
        
        
        document.querySelectorAll('.validation-invalid, .validation-valid').forEach(el => {
            el.classList.remove('validation-invalid', 'validation-valid');
            el.classList.add('validation-normal');
        });
        
        
        if (!validateAllFields()) {
            showMessage('Please fix all validation errors before downloading.', 'error');
            
            
            const firstError = document.querySelector('.validation-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            
            return false;
        }
        
       
        const selectedTemplate = document.getElementById('selectedTemplate').value;
        if (!selectedTemplate) {
            showMessage('Please select a template before downloading.', 'error');
            showTemplatePage();
            return false;
        }

       
        if (phoneInput.isValidNumber()) {
            document.getElementById('fullPhone').value = phoneInput.getNumber();
            console.log('Phone number processed:', phoneInput.getNumber());
        } else {
            showMessage('Please enter a valid phone number.', 'error');
            return false;
        }

        console.log('All validation passed');
        showMessage('Generating your resume PDF...', 'info');
        
        
        console.log('Submitting form for download...');
        document.getElementById('resumeForm').submit();
        return true;
    }

    function removeEmployment(button) {
        button.closest('.employment-item').remove();
        updateProgress();
        refreshPreview();
    }

    function removeEducation(button) {
        button.closest('.education-item').remove();
        updateProgress();
        refreshPreview();
    }

    function removeLanguage(button) {
        button.closest('.language-item').remove();
        updateProgress();
        refreshPreview();
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


    document.addEventListener('DOMContentLoaded', function() {
        const savedTemplate = localStorage.getItem('selectedTemplate');
        if (savedTemplate) {
            const template = JSON.parse(savedTemplate);
            
            
            document.getElementById('selectedTemplate').value = template.id;
            
            
            document.getElementById('currentTemplateName').textContent = template.name;
            document.getElementById('templateDescription').textContent = template.description;
            document.getElementById('templatePreviewInfo').classList.remove('hidden');
            
           
            refreshPreview();
            
           
            localStorage.removeItem('selectedTemplate');
            
           
            showMessage(`Template "${template.name}" selected! Start filling your resume details.`, 'success');
            
            
            document.getElementById('templatePreviewInfo').scrollIntoView({ 
                behavior: 'smooth' 
            });
        }
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
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300 cursor-pointer group" onclick="selectTemplate('${template.id}', '${template.name}', '${template.description}', '${template.view_name}', this)">
                    <div class="h-96 rounded-t-2xl overflow-hidden">
                        <img src="${template.image}" alt="${template.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
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
        document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
            card.classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
        });
        
        element.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
        
        document.getElementById('selectedTemplate').value = templateId;
        
        document.getElementById('currentTemplateName').textContent = templateName;
        document.getElementById('templateDescription').textContent = templateDescription;
        document.getElementById('templatePreviewInfo').classList.remove('hidden');

        showFormPage();
        refreshPreview();
        showMessage(`Template selected: ${templateName}`, 'success');
    }

  </script>
</body>
</html>
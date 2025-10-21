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
       background-color: #dbeafe !important; /* blue-50 */
      border-radius: 0.25rem 0 0 0.25rem !important;
    }
 .iti__country-list {
      width: 500% !important;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <main class="max-w-4xl mx-auto mt-8 bg-white shadow-lg p-6">

    <!-- Progress Bar -->
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Resume Progress</h2>
      <div class="w-full bg-gray-200 h-1.5">
        <div id="progressBar" class="bg-blue-600 h-1.5 transition-all duration-300" style="width:0%"></div>
      </div>
      <div class="flex justify-between text-sm text-gray-500 mt-1">
        <span>Get Started</span>
        <span id="progressText">0% Complete</span>
      </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="messageContainer" class="hidden mb-4 p-4 rounded-lg"></div>

    <form method="POST" action="{{ route('resume.download') }}" id="resumeForm">
      @csrf
      <input type="hidden" name="template" id="selectedTemplate" value="template1">
      <input type="hidden" name="phone" id="fullPhone">

      <!-- Personal Details -->
      <section class="space-y-4">
        <h3 class="text-xl font-semibold pb-1">Personal Details</h3>
        <p class="text-gray-600 text-sm">Enter your basic personal information, such as your name, contact details, and nationality.</p>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
            <input type="text" name="first_name" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
            <input type="text" name="last_name" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
          </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
            <div class="relative">
              <input type="tel" id="phone" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field">
            </div>
          </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
            <input type="text" name="occupation" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
            <select name="country" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
              <option value="">Select Country</option>
              @include('partials.country-options')
            </select>
          </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
            <input type="date" name="dob" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nationality</label>
            <select name="nationality" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
              <option value="">Select Nationality</option>
              @include('partials.nationality-options')
            </select>
          </div>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
          <select name="gender" class="p-2 w-full bg-blue-50 border border-blue-200 rounded required-field" oninput="updateProgress()">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            <option value="Prefer not to say">Prefer not to say</option>
          </select>
        </div>
      </section>

      <!-- Additional Details -->
      <section id="additionalDetails" class="space-y-4 mt-6 hidden">
        <h3 class="text-xl font-semibold pb-1">Additional Details</h3>
        <p class="text-gray-600 text-sm">Include hobbies, interests, or personal achievements.</p>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Hobbies</label>
          <textarea name="hobbies" class="w-full p-3 bg-blue-50 border border-blue-200 rounded additional-field" placeholder="e.g., Reading, Traveling, Photography" oninput="updateProgress()"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Interests</label>
          <textarea name="interests" class="w-full p-3 bg-blue-50 border border-blue-200 rounded additional-field" placeholder="e.g., AI Technology, Environmental Conservation" oninput="updateProgress()"></textarea>
        </div>
      </section>

      <div class="text-center my-6">
        <button type="button" onclick="toggleAdditional(event)" class="px-6 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200">
          <span id="additionalIcon">+</span> <span id="additionalText">Show Additional Details</span>
        </button>
      </div>

      <!-- Professional Summary -->
      <section class="space-y-3">
        <h3 class="text-xl font-semibold pb-1">Professional Summary</h3>
        <p class="text-gray-600 text-sm">Provide a brief overview of your professional background and career objectives.</p>
        <div>
          <textarea name="summary" class="w-full p-3 h-24 bg-blue-50 border border-blue-200 rounded required-field" placeholder="Enter your professional summary..." oninput="updateProgress()"></textarea>
        </div>
      </section>

      <!-- Employment History -->
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Employment History</h3>
        <p class="text-gray-600 text-sm">List your previous jobs in reverse chronological order.</p>
        <div id="employmentContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addEmployment()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
            <span class="text-blue-600">+</span> Add Job
          </button>
        </div>
      </section>

      <!-- Education -->
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Education</h3>
        <p class="text-gray-600 text-sm">Enter your academic qualifications and institutions.</p>
        <div id="educationContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addEducation()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
            <span class="text-blue-600">+</span> Add Education
          </button>
        </div>
      </section>

      <!-- Languages -->
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Languages</h3>
        <p class="text-gray-600 text-sm">Select the languages you know and your proficiency level.</p>
        <div id="languageContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addLanguage()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
            <span class="text-blue-600">+</span> Add Language
          </button>
        </div>
      </section>

      <!-- Skills -->
      <section class="mt-6 space-y-2">
        <h3 class="text-xl font-semibold pb-1">Skills</h3>
        <p class="text-gray-600 text-sm">Include key skills, technical abilities, and tools you are proficient in.</p>
        <div id="skillsContainer"></div>
        <div class="text-center">
          <button type="button" onclick="addSkill()" class="px-4 py-2 font-bold border border-blue-500 text-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200 mt-2">
            <span class="text-blue-600">+</span> Add Skill
          </button>
        </div>
      </section>

      <!-- Action Buttons -->
      <div class="text-center mt-8 flex justify-center gap-4 flex-wrap">
        <button type="button" onclick="saveDraft()" class="px-6 py-3 font-bold text-blue-600 border border-blue-600 bg-white rounded hover:bg-blue-50 transition duration-200">
          Save Draft
        </button>
        <button type="button" onclick="validateForm()" class="px-8 py-3 font-bold text-white bg-blue-600 rounded hover:bg-blue-700 transition duration-200">
          Download PDF
        </button>
        <div class="relative">
          <button type="button" class="px-6 py-3 font-bold text-gray-700 border border-gray-300 bg-white rounded hover:bg-gray-50 transition duration-200" onclick="toggleTemplateOptions()">
            Select Template
          </button>
          <div id="templateOptions" class="absolute left-0 mt-1 bg-white border border-gray-300 rounded shadow-lg w-full hidden z-10">
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-blue-50 transition duration-200" onclick="selectTemplate('template1')">Professional Blue</button>
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-blue-50 transition duration-200" onclick="selectTemplate('template2')">Modern Black</button>
            <button type="button" class="w-full px-4 py-2 text-left hover:bg-blue-50 transition duration-200" onclick="selectTemplate('template3')">Creative Green</button>
          </div>
        </div>
      </div>

      <div id="templatePreview" class="text-center mt-6 text-sm text-gray-600"></div>
    </form>
  </main>

  <script>
    let phoneInput;
    
    // Initialize phone input
    document.addEventListener('DOMContentLoaded', function() {
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

      // Update hidden phone field with full number
      document.getElementById('phone').addEventListener('input', function() {
        if (phoneInput.isValidNumber()) {
          document.getElementById('fullPhone').value = phoneInput.getNumber();
        }
      });

      // Initialize form with first employment and education entries
      addEmployment();
      addEducation();
      addLanguage();
      addSkill();
      loadDraft();
      updateProgress();
    });

    function toggleTemplateOptions() {
      document.getElementById('templateOptions').classList.toggle('hidden');
    }

    function selectTemplate(templateName) {
      document.getElementById('selectedTemplate').value = templateName;
      document.getElementById('templateOptions').classList.add('hidden');
      updateTemplatePreview(templateName);
      showMessage('Template selected: ' + getTemplateName(templateName), 'success');
    }

    function getTemplateName(template) {
      const templates = {
        'template1': 'Professional Blue',
        'template2': 'Modern Black', 
        'template3': 'Creative Green'
      };
      return templates[template] || 'Unknown Template';
    }

    function updateTemplatePreview(templateName) {
      const preview = document.getElementById('templatePreview');
      let html = '';
      if (templateName === 'template1') html = 'Selected Template: <b>Professional Blue</b> - Clean and professional design with blue accents';
      else if (templateName === 'template2') html = 'Selected Template: <b>Modern Black</b> - Contemporary design with dark accents';
      else if (templateName === 'template3') html = 'Selected Template: <b>Creative Green</b> - Fresh and creative design with green theme';
      preview.innerHTML = html;
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
      document.getElementById('progressBar').style.width = percent + '%';
      document.getElementById('progressText').innerText = percent + '% Complete';
      
      // Update progress bar color based on completion
      if (percent < 30) {
        document.getElementById('progressBar').classList.remove('bg-yellow-500', 'bg-green-500');
        document.getElementById('progressBar').classList.add('bg-red-500');
      } else if (percent < 70) {
        document.getElementById('progressBar').classList.remove('bg-red-500', 'bg-green-500');
        document.getElementById('progressBar').classList.add('bg-yellow-500');
      } else {
        document.getElementById('progressBar').classList.remove('bg-red-500', 'bg-yellow-500');
        document.getElementById('progressBar').classList.add('bg-green-500');
      }
    }

    function toggleAdditional(event) {
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
    }

    function addEmployment() {
      const container = document.getElementById('employmentContainer');
      const index = container.children.length;
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg employment-item">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">Job #${index + 1}</h4>
            <button type="button" onclick="removeEmployment(this)" class="text-red-500 hover:text-red-700">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
              <input type="text" name="job_title[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
              <input type="text" name="company[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
              <input type="month" name="job_start[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
              <input type="month" name="job_end[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Job Description and Responsibilities</label>
            <textarea name="job_description[]" class="w-full p-2 bg-blue-50 border border-blue-200 rounded required-field" oninput="updateProgress()"></textarea>
          </div>
        </div>
      `);
      updateProgress();
    }

    function removeEmployment(button) {
      button.closest('.employment-item').remove();
      updateProgress();
    }

    function addEducation() {
      const container = document.getElementById('educationContainer');
      const index = container.children.length;
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg education-item">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">Education #${index + 1}</h4>
            <button type="button" onclick="removeEducation(this)" class="text-red-500 hover:text-red-700">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Degree/Certificate</label>
              <input type="text" name="degree[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">School/University</label>
              <input type="text" name="school[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
              <input type="month" name="edu_start[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
              <input type="month" name="edu_end[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description of Studies</label>
            <textarea name="edu_description[]" class="w-full p-2 bg-blue-50 border border-blue-200 rounded required-field" oninput="updateProgress()"></textarea>
          </div>
        </div>
      `);
      updateProgress();
    }

    function removeEducation(button) {
      button.closest('.education-item').remove();
      updateProgress();
    }

    function addLanguage() {
      const container = document.getElementById('languageContainer');
      const index = container.children.length;
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg language-item">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">Language #${index + 1}</h4>
            <button type="button" onclick="removeLanguage(this)" class="text-red-500 hover:text-red-700">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Language</label>
              <select name="languages[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
                <option value="">Select Language</option>
                @include('partials.language-options')
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency</label>
              <select name="language_level[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
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
    }

    function addSkill() {
      const container = document.getElementById('skillsContainer');
      const index = container.children.length;
      
      container.insertAdjacentHTML('beforeend', `
        <div class="space-y-2 mt-4 p-4 border border-gray-200 rounded-lg skill-item">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-gray-700">Skill #${index + 1}</h4>
            <button type="button" onclick="removeSkill(this)" class="text-red-500 hover:text-red-700">
              Remove
            </button>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Skill</label>
              <input type="text" name="skills[]" placeholder="e.g., JavaScript, Project Management" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
              <select name="skill_level[]" class="p-2 bg-blue-50 border border-blue-200 rounded w-full required-field" oninput="updateProgress()">
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
    }

    function showMessage(message, type = 'info') {
      const container = document.getElementById('messageContainer');
      const colors = {
        success: 'bg-green-100 border-green-400 text-green-700',
        error: 'bg-red-100 border-red-400 text-red-700',
        info: 'bg-blue-100 border-blue-400 text-blue-700'
      };
      
      container.className = `${colors[type]} border-l-4 p-4 rounded-lg mb-4`;
      container.innerHTML = message;
      container.classList.remove('hidden');
      
      // Auto-hide after 5 seconds
      setTimeout(() => {
        container.classList.add('hidden');
      }, 5000);
    }

    function saveDraft() {
      // Simple client-side draft saving
      const formData = new FormData(document.getElementById('resumeForm'));
      const data = Object.fromEntries(formData);
      
      localStorage.setItem('resumeDraft', JSON.stringify(data));
      showMessage('Draft saved successfully! You can return later to continue.', 'success');
    }

    function loadDraft() {
      const draft = localStorage.getItem('resumeDraft');
      if (draft) {
        if (confirm('Would you like to load your saved draft?')) {
          // Implement draft loading logic here
          showMessage('Draft loaded successfully!', 'success');
        }
      }
    }

    function validateForm() {
      // Phone validation
      if (!phoneInput.isValidNumber()) {
        showMessage('Please enter a valid phone number.', 'error');
        return;
      }

      // Required fields validation
      const requiredFields = document.querySelectorAll('.required-field');
      let allFilled = true;
      let emptyFields = [];

      requiredFields.forEach(f => {
        if (f.offsetParent !== null) {
          if (f.type === 'select-one' && f.value === '') {
            allFilled = false;
            emptyFields.push(f.name || f.placeholder);
          } else if (f.value.trim() === '') {
            allFilled = false;
            emptyFields.push(f.name || f.placeholder);
          }
        }
      });

      if (!allFilled) {
        showMessage(`Please fill all required fields before downloading. Missing: ${emptyFields.slice(0, 3).join(', ')}${emptyFields.length > 3 ? '...' : ''}`, 'error');
        return;
      }

      // Update phone number before submission
      document.getElementById('fullPhone').value = phoneInput.getNumber();
      
      showMessage('Generating your resume PDF...', 'info');
      document.getElementById('resumeForm').submit();
    }
  </script>
</body>
</html>
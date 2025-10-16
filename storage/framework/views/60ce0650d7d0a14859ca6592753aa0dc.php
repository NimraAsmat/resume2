<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - <?php echo e($first_name ?? ''); ?> <?php echo e($last_name ?? ''); ?></title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            line-height: 1.6; 
            color: #000; 
            padding: 40px;
            margin: 0;
            background: #fff; 
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff; 
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }

        h1 { 
            color: #2563eb; 
            font-size: 36px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        h3 {
            color: #2563eb; 
            font-size: 20px;
        }

        p, li {
            font-size: 16px;
        }

        em { font-style: italic; } 

        .contact-info {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }

        .contact-info ul {
            list-style-type: disc; 
            padding-left: 20px;
            margin: 0;
        }

        .contact-info li {
            margin-bottom: 5px;
        }

        .section {
            margin-bottom: 15px; 
        }

        .job-item, .edu-item p {
            margin: 5px 0; 
        }

        strong {
            color: #000; 
        }

        .edu-item strong {
            color: #000; 
            font-weight: bold;
        }

        ul.skills, ul.languages {
            padding-left: 20px;
            list-style-type: disc;
        }

        ul {
            margin: 5px 0; 
            padding-left: 20px; 
        }

        .footer {
            margin-top: 40px;
            color: #666;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        
        h1, h3, p, li {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo e($first_name ?? 'First Name'); ?> <?php echo e($last_name ?? 'Last Name'); ?></h1>
        
        <div class="contact-info">
            <ul>
                <li><strong>Email:</strong> <?php echo e($email ?? 'N/A'); ?></li>
                <li><strong>Phone:</strong> <?php echo e($phone ?? 'N/A'); ?></li>
                <li><strong>Occupation:</strong> <?php echo e($occupation ?? 'N/A'); ?></li>
                <li><strong>Country:</strong> <?php echo e($country ?? 'N/A'); ?></li>
                <?php if(!empty($nationality)): ?>
                    <li><strong>Nationality:</strong> <?php echo e($nationality); ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <?php if(!empty($summary)): ?>
        <div class="section">
            <h3>Professional Summary</h3>
            <p><?php echo e($summary); ?></p>
        </div>
        <?php endif; ?>

        <?php if(!empty($employment) && count($employment) > 0): ?>
        <div class="section">
            <h3>Employment History</h3>
            <?php $__currentLoopData = $employment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="job-item">
                <strong><?php echo e($job['job_title'] ?? 'Job Title'); ?>

                <?php if(!empty($job['company'])): ?>
                    at <?php echo e($job['company']); ?>

                <?php endif; ?>
                </strong>
                <br>
                <?php if(!empty($job['job_start']) || !empty($job['job_end'])): ?>
                    <em>
                        <?php echo e($job['job_start'] ?? 'Start'); ?>

                        <?php if(!empty($job['job_start']) && !empty($job['job_end'])): ?> - <?php endif; ?>
                        <?php echo e($job['job_end'] ?? 'End'); ?>

                    </em>
                    <br>
                <?php endif; ?>
                <?php if(!empty($job['job_description'])): ?>
                    <?php echo e($job['job_description']); ?>

                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($education) && count($education) > 0): ?>
        <div class="section">
            <h3>Education</h3>
            <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="edu-item">
                <strong>
                    <?php echo e($edu['degree'] ?? 'Degree'); ?>

                    <?php if(!empty($edu['school'])): ?>
                        at <?php echo e($edu['school']); ?>

                    <?php endif; ?>
                </strong>
                <br>
                <?php if(!empty($edu['edu_start']) || !empty($edu['edu_end'])): ?>
                    <em>
                        <?php echo e($edu['edu_start'] ?? 'Start'); ?>

                        <?php if(!empty($edu['edu_start']) && !empty($edu['edu_end'])): ?> - <?php endif; ?>
                        <?php echo e($edu['edu_end'] ?? 'End'); ?>

                    </em>
                    <br>
                <?php endif; ?>
                <?php if(!empty($edu['edu_description'])): ?>
                    <?php echo e($edu['edu_description']); ?>

                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($skills) && count($skills) > 0): ?>
        <div class="section">
            <h3>Skills</h3>
            <ul class="skills">
                <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($skill); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if(!empty($languages) && count($languages) > 0): ?>
        <div class="section">
            <h3>Languages</h3>
            <ul class="languages">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($lang); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if(!empty($hobbies) || !empty($interests)): ?>
        <div class="section">
            <h3>Additional Information</h3>
            <?php if(!empty($hobbies)): ?>
                <p><strong>Hobbies:</strong> <?php echo e($hobbies); ?></p>
            <?php endif; ?>
            <?php if(!empty($interests)): ?>
                <p><strong>Interests:</strong> <?php echo e($interests); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="footer">
            Generated on: <?php echo e(date('F j, Y')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\resume2\resources\views/templates/template1.blade.php ENDPATH**/ ?>
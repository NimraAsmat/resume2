<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - <?php echo e($first_name ?? ''); ?> <?php echo e($last_name ?? ''); ?></title>
    <style>
        body { 
            font-family: DejaVu Sans, Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background: #fff; /* White background */
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            background: white; 
            padding: 40px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .header { 
            background: #059669; 
            color: white; 
            padding: 30px; 
            margin: -40px -40px 30px -40px; 
            text-align: center; /* Centered header */
        }
        .header h1 { 
            font-size: 32px; 
            margin: 0; 
        }
        .header p { 
            margin: 5px 0; 
            opacity: 0.9; 
        }
        .section { 
            margin-bottom: 25px; 
        }
        .section-title { 
            color: #059669; 
            font-size: 18px; 
            font-weight: bold; 
            border-left: 4px solid #059669; 
            padding-left: 10px; 
            margin-bottom: 15px; 
        }
        .job-item, .edu-item { 
            background: #f0fdf4; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px; 
        }
        .job-title, .edu-degree { 
            font-weight: bold; 
            color: #065f46; 
        }
        .company, .school { 
            color: #047857; 
        }
        .date { 
            color: #064e3b; 
            font-size: 14px; 
        }
        .grid-2 { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 20px; 
        }
        ul { 
            padding-left: 20px; 
        }
        li { 
            margin-bottom: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><?php echo e($first_name ?? 'First Name'); ?> <?php echo e($last_name ?? 'Last Name'); ?></h1>
            <p><?php echo e($occupation ?? 'Professional'); ?></p>
            <p>
                <?php echo e($email ?? ''); ?> 
                <?php if(!empty($email) && !empty($phone)): ?> | <?php endif; ?> 
                <?php echo e($phone ?? ''); ?> 
                <?php if((!empty($email) || !empty($phone)) && !empty($country)): ?> | <?php endif; ?> 
                <?php echo e($country ?? ''); ?>

            </p>
        </div>

        <!-- Professional Summary -->
        <?php if(!empty($summary)): ?>
        <div class="section">
            <div class="section-title">PROFESSIONAL SUMMARY</div>
            <p><?php echo e($summary); ?></p>
        </div>
        <?php endif; ?>

        <!-- Work Experience -->
        <?php if(!empty($employment) && count($employment) > 0): ?>
        <div class="section">
            <div class="section-title">WORK EXPERIENCE</div>
            <?php $__currentLoopData = $employment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="job-item">
                <div class="job-title"><?php echo e($job['job_title'] ?? 'Job Title'); ?></div>
                <div class="company"><?php echo e($job['company'] ?? ''); ?></div>
                <div class="date">
                    <?php echo e($job['job_start'] ?? ''); ?> 
                    <?php if(!empty($job['job_start']) && !empty($job['job_end'])): ?> - <?php endif; ?> 
                    <?php echo e($job['job_end'] ?? ''); ?>

                </div>
                <?php if(!empty($job['job_description'])): ?>
                <p><?php echo e($job['job_description']); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <!-- Education -->
        <?php if(!empty($education) && count($education) > 0): ?>
        <div class="section">
            <div class="section-title">EDUCATION</div>
            <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="edu-item">
                <div class="edu-degree"><?php echo e($edu['degree'] ?? 'Degree'); ?></div>
                <div class="school"><?php echo e($edu['school'] ?? ''); ?></div>
                <div class="date">
                    <?php echo e($edu['edu_start'] ?? ''); ?> 
                    <?php if(!empty($edu['edu_start']) && !empty($edu['edu_end'])): ?> - <?php endif; ?> 
                    <?php echo e($edu['edu_end'] ?? ''); ?>

                </div>
                <?php if(!empty($edu['edu_description'])): ?>
                <p><?php echo e($edu['edu_description']); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <!-- Additional Details -->
        <?php if(!empty($hobbies) || !empty($interests)): ?>
        <div class="section">
            <div class="section-title">ADDITIONAL DETAILS</div>
            <?php if(!empty($hobbies)): ?>
                <p><strong>Hobbies:</strong> <?php echo e($hobbies); ?></p>
            <?php endif; ?>
            <?php if(!empty($interests)): ?>
                <p><strong>Interests:</strong> <?php echo e($interests); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Skills & Languages -->
        <?php if((!empty($skills) && count($skills) > 0) || (!empty($languages) && count($languages) > 0)): ?>
        <div class="section">
            <div class="grid-2">
                <?php if(!empty($skills) && count($skills) > 0): ?>
                <div>
                    <div class="section-title">SKILLS</div>
                    <ul>
                        <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($skill); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($languages) && count($languages) > 0): ?>
                <div>
                    <div class="section-title">LANGUAGES</div>
                    <ul>
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($lang); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Footer -->
        <div style="margin-top: 40px; font-size: 12px; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 20px;">
            Generated on: <?php echo e(date('F j, Y')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\resume\resources\views/templates/template3.blade.php ENDPATH**/ ?>
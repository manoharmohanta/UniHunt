<?php
$event = $event ?? null;
$title = $title ?? 'Event';
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="max-w-6xl mx-auto" x-data="eventForm()">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="<?= base_url('admin/events') ?>" 
               class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight"><?= $title ?></h2>
                <p class="text-sm text-slate-500">Manage event details, agenda, and speakers.</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" @click="submitForm()" 
                    class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2 text-sm text-white">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <?= isset($event) ? 'Update Event' : 'Create Event' ?>
            </button>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
            <div class="p-4 mb-8 rounded-xl bg-red-50 border border-red-200 text-red-700 shadow-sm animate-shake">
                <div class="flex items-center gap-2 mb-2 font-bold text-red-800">
                    <span class="material-symbols-outlined">error</span>
                    Please correct the following:
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 ml-6">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
    <?php endif ?>

    <form id="main-form" action="<?= isset($event) ? base_url('admin/events/update/' . $event['id']) : base_url('admin/events/create') ?>" 
          method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <?= csrf_field() ?>

        <!-- Left Column: Main Content -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Basic Details -->
            <div class="bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">description</span>
                    <h3 class="font-bold text-slate-800">Basic Details</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Event Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="<?= old('title', $event['title'] ?? '') ?>" 
                               class="w-full h-12 rounded-xl border-2 border-slate-300 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm px-4"
                               placeholder="Enter a catchy title" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Short Description</label>
                        <textarea name="short_description" rows="2" 
                                  class="w-full rounded-xl border-2 border-slate-300 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm px-4 py-2"
                                  placeholder="Used for event cards and previews..."><?= old('short_description', $event['short_description'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Detailed Content</label>
                        <div id="quill-editor" style="height: 400px;" class="rounded-b-xl border-2 border-slate-300">
                            <?= old('description', $event['description'] ?? '') ?>
                        </div>
                        <textarea name="description" id="description-textarea" class="hidden"></textarea>
                    </div>
                </div>
            </div>

            <!-- Dynamic Agenda Section -->
            <div class="bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">schedule</span>
                        <h3 class="font-bold text-slate-800">Event Agenda</h3>
                    </div>
                    <button type="button" @click="addAgenda()" 
                            class="text-xs font-bold bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all flex items-center gap-1 border border-indigo-100 shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">add</span> Add Item
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(item, index) in agenda" :key="index">
                        <div class="p-4 rounded-xl border-2 border-slate-200 bg-slate-50/30 flex gap-4 items-start relative group">
                            <div class="flex-grow grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <input type="text" x-model="item.time" placeholder="Time (e.g. 10:00 AM)" 
                                           class="w-full rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 px-3 py-2">
                                </div>
                                <div class="md:col-span-3">
                                    <input type="text" x-model="item.title" placeholder="Topic/Title" 
                                           class="w-full rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 mb-2 px-3 py-2">
                                    <textarea x-model="item.description" placeholder="Brief description..." rows="2"
                                              class="w-full rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 px-3 py-2"></textarea>
                                </div>
                            </div>
                            <button type="button" @click="removeAgenda(index)" 
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </template>
                    <div x-show="agenda.length === 0" class="text-center py-10 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400">
                        <p class="text-sm italic">No agenda items added yet.</p>
                    </div>
                    <input type="hidden" name="agenda_json" :value="JSON.stringify(agenda)">
                </div>
            </div>

            <!-- Speakers Section -->
            <div class="bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">groups</span>
                        <h3 class="font-bold text-slate-800">Speakers</h3>
                    </div>
                    <button type="button" @click="addSpeaker()" 
                            class="text-xs font-bold bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all flex items-center gap-1 border border-indigo-100 shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">person_add</span> Add Speaker
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(speaker, index) in speakers" :key="index">
                        <div class="p-4 rounded-xl border-2 border-slate-200 bg-slate-50/30 flex gap-4 items-center group">
                            <div class="size-12 rounded-full bg-slate-200 shrink-0 overflow-hidden flex items-center justify-center text-slate-400 border border-slate-300">
                                <img :src="speaker.image" x-show="speaker.image" class="w-full h-full object-cover">
                                <span class="material-symbols-outlined" x-show="!speaker.image">person</span>
                            </div>
                            <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" x-model="speaker.name" placeholder="Full Name" 
                                       class="w-full rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 px-3 py-2">
                                <input type="text" x-model="speaker.role" placeholder="Role (e.g. Dean of Admissions)" 
                                       class="w-full rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 px-3 py-2">
                                <input type="text" x-model="speaker.image" placeholder="Image URL (optional)" 
                                       class="md:col-span-2 w-full rounded-lg border-2 border-slate-300 text-xs focus:ring-indigo-500 px-3 py-2">
                            </div>
                            <button type="button" @click="removeSpeaker(index)" 
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </template>
                    <div x-show="speakers.length === 0" class="text-center py-10 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400">
                        <p class="text-sm italic">No speakers listed.</p>
                    </div>
                    <input type="hidden" name="speakers_json" :value="JSON.stringify(speakers)">
                </div>
            </div>

            <!-- Learning Points -->
            <div class="bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">checklist</span>
                        <h3 class="font-bold text-slate-800">What they will learn</h3>
                    </div>
                    <button type="button" @click="addPoint()" 
                            class="text-xs font-bold bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all flex items-center gap-1 border border-indigo-100 shadow-sm">
                        <span class="material-symbols-outlined text-[14px]">add</span> Add Point
                    </button>
                </div>
                <div class="p-6 space-y-3">
                    <template x-for="(point, index) in points" :key="index">
                        <div class="flex gap-2 group">
                            <input type="text" x-model="points[index]" placeholder="e.g. Scholarship opportunities..." 
                                   class="flex-grow rounded-lg border-2 border-slate-300 text-sm focus:ring-indigo-500 px-3 py-2">
                            <button type="button" @click="removePoint(index)" 
                                    class="p-2 rounded-lg text-slate-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">close</span>
                            </button>
                        </div>
                    </template>
                    <div x-show="points.length === 0" class="text-center py-6 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 text-sm italic">
                        No learning points added.
                    </div>
                    <input type="hidden" name="learning_points_json" :value="JSON.stringify(points)">
                </div>
            </div>
        </div>

        <!-- Right Column: Settings & Meta -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Publishing Card -->
            <div class="bg-white rounded-2xl border border-slate-300 shadow-sm p-6 space-y-6 sticky top-24 transition-all hover:shadow-md">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Status</label>
                        <select name="status" class="w-full h-11 rounded-xl border-2 border-slate-300 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all px-3">
                            <option value="draft" <?= (old('status', $event['status'] ?? '') == 'draft') ? 'selected' : '' ?>>Draft</option>
                            <option value="published" <?= (old('status', $event['status'] ?? '') == 'published') ? 'selected' : '' ?>>Published</option>
                            <option value="cancelled" <?= (old('status', $event['status'] ?? '') == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            <option value="archived" <?= (old('status', $event['status'] ?? '') == 'archived') ? 'selected' : '' ?>>Archived</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Event Type</label>
                        <select name="event_type" class="w-full h-11 rounded-xl border-2 border-slate-300 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all px-3">
                            <?php
                            $types = ['Webinar', 'University Fair', 'Workshop', 'Seminar', 'Open Day', 'Q&A Session', 'Campus Tour'];
                            foreach ($types as $type): ?>
                                    <option value="<?= strtolower(str_replace(' ', '_', $type)) ?>" <?= (old('event_type', $event['event_type'] ?? '') == strtolower(str_replace(' ', '_', $type))) ? 'selected' : '' ?>>
                                        <?= $type ?>
                                    </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-slate-300 cursor-pointer transition-all hover:bg-indigo-50/30 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50 group">
                            <input type="checkbox" name="is_featured" value="1" class="hidden" <?= (old('is_featured', $event['is_featured'] ?? 0)) ? 'checked' : '' ?>>
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-600 transition-colors mb-1">star</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 group-hover:text-indigo-700">Featured</span>
                        </label>
                        <label class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-slate-300 cursor-pointer transition-all hover:bg-purple-50/30 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50/50 group">
                            <input type="checkbox" name="is_premium" value="1" class="hidden" <?= (old('is_premium', $event['is_premium'] ?? 0)) ? 'checked' : '' ?>>
                            <span class="material-symbols-outlined text-slate-400 group-hover:text-purple-600 transition-colors mb-1">workspace_premium</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 group-hover:text-purple-700">Premium</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-200">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Schedule</h4>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Start Date</label>
                        <input type="date" name="start_date" value="<?= old('start_date', $event['start_date'] ?? '') ?>" 
                               class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 px-3" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Start Time</label>
                            <input type="time" name="start_time" value="<?= old('start_time', $event['start_time'] ?? '') ?>" 
                                   class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 px-3">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">End Time</label>
                            <input type="time" name="end_time" value="<?= old('end_time', $event['end_time'] ?? '') ?>" 
                                   class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 px-3">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Timezone</label>
                        <select name="timezone" class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 px-3">
                            <?php $tzs = DateTimeZone::listIdentifiers();
                            foreach ($tzs as $tz): ?>
                                    <option value="<?= $tz ?>" <?= (old('timezone', $event['timezone'] ?? 'UTC') == $tz) ? 'selected' : '' ?>><?= $tz ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-200">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Location</h4>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Location Type</label>
                        <select name="location_type" class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm px-3">
                            <option value="online" <?= (old('location_type', $event['location_type'] ?? '') == 'online') ? 'selected' : '' ?>>Online / Virtual</option>
                            <option value="venue" <?= (old('location_type', $event['location_type'] ?? '') == 'venue') ? 'selected' : '' ?>>Physical Venue</option>
                            <option value="mixed" <?= (old('location_type', $event['location_type'] ?? '') == 'mixed') ? 'selected' : '' ?>>Hybrid</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Location Name</label>
                        <input type="text" name="location_name" value="<?= old('location_name', $event['location_name'] ?? '') ?>" 
                               class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-indigo-500 px-3" placeholder="e.g. Zoom, Excel Centre...">
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-200">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Meta & Links</h4>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cost / Fee</label>
                        <input type="text" name="cost" value="<?= old('cost', $event['cost'] ?? 'Free') ?>" 
                               class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-indigo-500 px-3">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Registration Link</label>
                        <input type="url" name="registration_link" value="<?= old('registration_link', $event['registration_link'] ?? '') ?>" 
                               class="w-full h-11 rounded-xl border-2 border-slate-300 shadow-sm focus:ring-indigo-500 px-3" placeholder="https://...">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Featured Image</label>
                        <div class="mt-2 group relative">
                            <div class="aspect-video rounded-xl bg-slate-50 border-2 border-slate-300 flex flex-col items-center justify-center overflow-hidden hover:border-indigo-400 transition-all cursor-pointer" onclick="document.getElementById('img-input').click()">
                                <?php if (!empty($event['image'])): ?>
                                        <img src="<?= base_url($event['image']) ?>" id="img-preview" class="w-full h-full object-cover">
                                <?php else: ?>
                                        <span class="material-symbols-outlined text-slate-300 text-[40px]">image</span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-2">Upload Cover</span>
                                <?php endif; ?>
                            </div>
                            <input type="file" id="img-input" name="image" class="hidden" onchange="previewImage(this)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = input.parentElement.querySelector('.aspect-video');
                container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function eventForm() {
        return {
            agenda: <?= isset($event['agenda']) ? (is_array($event['agenda']) ? json_encode($event['agenda']) : $event['agenda']) : '[]' ?>,
            speakers: <?= isset($event['speakers']) ? (is_array($event['speakers']) ? json_encode($event['speakers']) : $event['speakers']) : '[]' ?>,
            points: <?= isset($event['learning_points']) ? (is_array($event['learning_points']) ? json_encode($event['learning_points']) : $event['learning_points']) : '[]' ?>,

            addAgenda() {
                this.agenda.push({ time: '', title: '', description: '' });
            },
            removeAgenda(index) {
                this.agenda.splice(index, 1);
            },
            addSpeaker() {
                this.speakers.push({ name: '', role: '', image: '' });
            },
            removeSpeaker(index) {
                this.speakers.splice(index, 1);
            },
            addPoint() {
                this.points.push('');
            },
            removePoint(index) {
                this.points.splice(index, 1);
            },
            submitForm() {
                // Sync Quill content to hidden textarea
                document.getElementById('description-textarea').value = quill.root.innerHTML;
                document.getElementById('main-form').submit();
            }
        }
    }
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.4s ease-in-out; }
    
    /* Quill Styling Adjustments */
    .ql-toolbar.ql-snow {
        border-color: #cbd5e1 !important;
        border-width: 2px !important;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        background: #f8fafc;
    }
    .ql-container.ql-snow {
        border-color: #cbd5e1 !important;
        border-width: 2px !important;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        font-family: inherit;
        font-size: 0.875rem;
    }

    /* Force borders on all inputs and selects as requested */
    input, select, textarea {
        border-width: 2px !important;
        border-color: #cbd5e1 !important;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #6366f1 !important;
        outline: none;
    }
</style>
<?= $this->endSection() ?>

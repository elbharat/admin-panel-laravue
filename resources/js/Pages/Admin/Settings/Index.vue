<template>
    <ModernAdminLayout title="Pengaturan Website">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Pengaturan Website</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Kelola pengaturan umum website seperti judul, logo, dan lainnya.
                            </p>
                        </header>

                        <form @submit.prevent="form.post(route('admin.settings.update'))" class="mt-6 space-y-6" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Website Title -->
                                <div>
                                    <InputLabel for="website_title" value="Judul Website" />
                                    <TextInput
                                        id="website_title"
                                        v-model="form.website_title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.website_title" class="mt-2" />
                                </div>

                                <!-- Website Subtitle -->
                                <div>
                                    <InputLabel for="website_subtitle" value="Subtitle Website" />
                                    <TextInput
                                        id="website_subtitle"
                                        v-model="form.website_subtitle"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.website_subtitle" class="mt-2" />
                                </div>

                                <!-- Website Logo -->
                                <div>
                                    <InputLabel for="website_logo" value="Logo Website" />
                                    <div class="mt-2 flex items-center gap-4">
                                        <img v-if="logoPreview" :src="logoPreview" class="h-20 w-auto object-contain" />
                                        <img v-else-if="websiteLogo" :src="'/storage/' + websiteLogo" class="h-20 w-auto object-contain" />
                                        <div v-else class="h-20 w-40 flex items-center justify-center bg-gray-100 rounded-md">
                                            <span class="text-gray-400">Tidak ada logo</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input
                                            type="file"
                                            id="website_logo"
                                            @input="form.website_logo = $event.target.files[0]; updateLogoPreview()"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80"
                                            accept="image/*"
                                        />
                                    </div>
                                    <InputError :message="form.errors.website_logo" class="mt-2" />
                                </div>

                                <!-- Website Favicon -->
                                <div>
                                    <InputLabel for="website_favicon" value="Favicon Website" />
                                    <div class="mt-2 flex items-center gap-4">
                                        <img v-if="faviconPreview" :src="faviconPreview" class="h-10 w-auto object-contain" />
                                        <img v-else-if="websiteFavicon" :src="'/storage/' + websiteFavicon" class="h-10 w-auto object-contain" />
                                        <div v-else class="h-10 w-10 flex items-center justify-center bg-gray-100 rounded-md">
                                            <span class="text-gray-400 text-xs">Tidak ada</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input
                                            type="file"
                                            id="website_favicon"
                                            @input="form.website_favicon = $event.target.files[0]; updateFaviconPreview()"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80"
                                            accept="image/x-icon,image/png"
                                        />
                                    </div>
                                    <InputError :message="form.errors.website_favicon" class="mt-2" />
                                </div>

                                <!-- Website Thumbnail -->
                                <div class="md:col-span-2">
                                    <InputLabel for="website_thumbnail" value="Thumbnail Website (OG Image)" />
                                    <div class="mt-2 flex items-center gap-4">
                                        <img v-if="thumbnailPreview" :src="thumbnailPreview" class="h-40 w-auto object-contain" />
                                        <img v-else-if="websiteThumbnail" :src="'/storage/' + websiteThumbnail" class="h-40 w-auto object-contain" />
                                        <div v-else class="h-40 w-80 flex items-center justify-center bg-gray-100 rounded-md">
                                            <span class="text-gray-400">Tidak ada thumbnail</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input
                                            type="file"
                                            id="website_thumbnail"
                                            @input="form.website_thumbnail = $event.target.files[0]; updateThumbnailPreview()"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/80"
                                            accept="image/*"
                                        />
                                    </div>
                                    <InputError :message="form.errors.website_thumbnail" class="mt-2" />
                                </div>

                                <!-- Footer Copyright -->
                                <div class="md:col-span-2">
                                    <InputLabel for="footer_copyright" value="Teks Copyright Footer" />
                                    <TextInput
                                        id="footer_copyright"
                                        v-model="form.footer_copyright"
                                        type="text"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.footer_copyright" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Simpan Pengaturan</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-green-600">Pengaturan berhasil disimpan.</p>
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </ModernAdminLayout>
</template>

<script setup>
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import PrimaryButton from '@/Components/ui/primary-button.vue';
import TextInput from '@/Components/ui/input.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    websiteTitle: String,
    websiteSubtitle: String,
    websiteLogo: String,
    websiteFavicon: String,
    websiteThumbnail: String,
    footerCopyright: String,
});

const form = useForm({
    website_title: props.websiteTitle,
    website_subtitle: props.websiteSubtitle,
    website_logo: null,
    website_favicon: null,
    website_thumbnail: null,
    footer_copyright: props.footerCopyright,
});

const logoPreview = ref(null);
const faviconPreview = ref(null);
const thumbnailPreview = ref(null);

const updateLogoPreview = () => {
    if (!form.website_logo) {
        logoPreview.value = null;
        return;
    }
    
    const reader = new FileReader();
    reader.onload = (e) => {
        logoPreview.value = e.target.result;
    };
    reader.readAsDataURL(form.website_logo);
};

const updateFaviconPreview = () => {
    if (!form.website_favicon) {
        faviconPreview.value = null;
        return;
    }
    
    const reader = new FileReader();
    reader.onload = (e) => {
        faviconPreview.value = e.target.result;
    };
    reader.readAsDataURL(form.website_favicon);
};

const updateThumbnailPreview = () => {
    if (!form.website_thumbnail) {
        thumbnailPreview.value = null;
        return;
    }
    
    const reader = new FileReader();
    reader.onload = (e) => {
        thumbnailPreview.value = e.target.result;
    };
    reader.readAsDataURL(form.website_thumbnail);
};
</script> 
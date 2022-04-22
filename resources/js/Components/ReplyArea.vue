<template>
    <div class="mt-2 text-sm space-x-2">
		<span class="text-gray-500 font-medium">{{date}}</span>
		{{ ' ' }}
		<span class="text-gray-500 font-medium">&middot;</span>
		{{ ' ' }}
		<button v-if="depth < 3" type="button" class="text-gray-900 font-bold" @click="show = true">Reply</button>
		<div v-if="show" class="w-full px-4 sm:px-6">
			<div class="flex space-x-3">
				<div class="min-w-0 flex-1">
					<div class="mt-2">
						<input type="text" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md md:w-1/4" name="name" id="name" placeholder="Enter name..." v-model="form.name">
						<ErrorMessage class="mt-2" :message="form.errors.name" />
					</div>
					<div class="mt-2">
						<textarea id="comment" name="comment" rows="1" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md" placeholder="Leave a reply here..." v-model="form.body" />
						<ErrorMessage class="mt-2" :message="form.errors.body" />
					</div>
					<div class="mt-3 flex items-center justify-end">
						<button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" @click="reply" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Reply</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'

const props = defineProps({
    depth: Number,
    parentId: Number,
    date: String
});

const show = ref(false)
const form = reactive(useForm({
    name: null,
    body: null,
}))

function reply() {
	form.post(route('comments.reply', {comment: props.parentId}),{
  		preserveScroll: true,
        onSuccess: response => {
        	form.reset()
        	show.value = false
        }
    })
}
</script>

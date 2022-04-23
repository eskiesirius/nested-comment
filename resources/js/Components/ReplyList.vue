<template>
	<li :class="'ml-' + ((comment.depth) * 8)" class="bg-white p-2 border rounded-md mt-2">
		<div class="flex space-x-3 mb-3">
			<div class="flex-shrink-0">
				<img class="h-10 w-10 rounded-full" :src="'https://ui-avatars.com/api/?name=' + encodeURI(comment.name) + '&color=7F9CF5&background=EBF4FF'" alt="" />
			</div>
			<div class="w-full">
				<div class="text-sm">
					<a href="#" class="font-medium text-gray-900">{{comment.name}}</a>
				</div>
				<div class="mt-1 text-sm text-gray-700">
					<p>{{comment.body}}</p>
				</div>
				<div class="mt-2 text-sm space-x-2">
					<span class="text-gray-500 font-medium">{{comment.created_at}}</span>
					{{ ' ' }}
					<span class="text-gray-500 font-medium">&middot;</span>
					{{ ' ' }}
					<button v-if="comment.depth + 1 < 3" type="button" class="text-gray-900 font-bold" @click="show = true">Reply</button>
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
			</div>
		</div>
		<template v-if="comment.replies.length != 0">
			<ul role="list" :class="'ml-' + ((comment.depth) * 8)">
				<ReplyList v-for="reply in comment.replies" :comment="reply" :key="reply.id" />
			</ul>
		</template>
	</li>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'

import ErrorMessage from '@/Components/ErrorMessage.vue'
import ReplyList from '@/Components/ReplyList.vue'

const props = defineProps({
    comment: Object,
})

const show = ref(false)
const form = reactive(useForm({
    name: null,
    body: null,
}))

function reply() {
	form.post(route('comments.reply', {comment: props.comment.id}),{
  		preserveScroll: true,
        onSuccess: response => {
        	form.reset()
        	show.value = false
        }
    })
}

</script>

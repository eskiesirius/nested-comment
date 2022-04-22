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
				<ReplyArea :date="comment.created_at" :depth="comment.depth + 1" :parentId="comment.id"/>
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
import ReplyList from '@/Components/ReplyList.vue'
import ReplyArea from '@/Components/ReplyArea.vue'

defineProps({
    comment: Object,
})

</script>

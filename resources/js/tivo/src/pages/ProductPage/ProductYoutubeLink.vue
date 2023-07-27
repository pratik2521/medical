<template>
  <div>
    <div class="row" v-for="item in youtubelink" :key="item.youtubelink">
      <iframe
        width="560"
        height="500"
        :src="getYoutubeEmbedLink(item.youtubelink)"
        frameborder="0"
        allowfullscreen
      ></iframe>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductDetails",
  props: {
    youtubelink: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  methods: {
    getYoutubeEmbedLink(youtubeLink) {
      if (!youtubeLink) return "";
      const videoIdMatch = youtubeLink.match(/(?:\/\w+\?v=|\/embed\/)([\w-]+)/);
      if (!videoIdMatch || !videoIdMatch[1]) return "";

      const videoId = videoIdMatch[1];
      return `https://www.youtube.com/embed/${videoId}`;
    },
  },
};
</script>
<style>
.youtube-video {
  width: 100%;
  height: 550px;
  border: 1px solid #ccc;
}
</style>

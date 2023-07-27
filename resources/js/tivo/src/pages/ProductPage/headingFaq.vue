<!-- <template>
    <div v-if="accordionItems.length > 0">
      <div class="container" v-for="(item, index) in accordionItems" :key="index" :class="{ 'image-right': item.imagePosition === 'right' }">
        <div class="image-container">
          <img :src="item.imageUrl" :alt="item.title">
        </div>
        <div class="data-container">
          <h2>{{ item.title }}</h2>
          <div class="accordion">
            <div v-for="(content, i) in item.contents" :key="i">
              <button @click="toggleAccordion(index, i)" :class="{ active: activeAccordion === `${index}_${i}` }">
                {{ content.heading }}
              </button>
              <div v-if="activeAccordion === `${index}_${i}`" class="accordion-content">
                {{ content.text }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      No data to display.
    </div>
  </template>
  
  <script>
  export default {
    props: {
      accordionItems: Array,
    },
    data() {
      return {
        activeAccordion: null,
      };
    },
    methods: {
      toggleAccordion(index, i) {
        const accordionKey = `${index}_${i}`;
        this.activeAccordion = this.activeAccordion === accordionKey ? null : accordionKey;
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    display: flex;
    align-items: center;
  }
  
  .image-container {
    flex: 1;
  }
  
  .image-container img {
    max-width: 100%;
    height: auto;
  }
  
  .data-container {
    flex: 1;
    padding: 20px;
  }
  
  .data-container h2 {
    font-size: 24px;
    margin-bottom: 15px;
  }
  
 
  .image-right {
    flex-direction: row-reverse;
  }
  
  .accordion-btn {
    background-color: #f9f9f9;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: background-color 0.2s;
  }
  
  .accordion-btn.active {
    background-color: #ddd;
  }
  
  .accordion-content {
    display: none;
    padding: 20px;
  }
  
  .accordion-content.active {
    display: block;
  }
  </style>
   -->
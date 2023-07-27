<template>
  <div>
    <ul class="list">
      <li v-for="item in paginatedList" :key="item"></li>
    </ul>
    <ul class="google-pagination">
      <li :class="['pagination-item', { disabled: currentPage === 1 }]" @click="onPrevious">
        <i class="fa fa-angle-left"></i>
      </li>
      <li class="pagination-item" v-if="paginationRange[0] > 1">
        <button @click="selectPage(1)">1</button>
      </li>
      <li class="pagination-item" v-if="paginationRange[0] > 2">
        <span>...</span>
      </li>
      <li v-for="pageNumber in visiblePaginationRange" :key="pageNumber">
        <button :class="['pagination-item', { active: pageNumber === currentPage }]" @click="selectPage(pageNumber)">
          {{ pageNumber }}
        </button>
      </li>
      <li class="pagination-item" v-if="paginationRange[paginationRange.length - 1] < lastPage - 1">
        <span>...</span>
      </li>
      <li class="pagination-item" v-if="paginationRange[paginationRange.length - 1] < lastPage">
        <button @click="selectPage(lastPage)">{{ lastPage }}</button>
      </li>
      <li :class="['pagination-item', { disabled: currentPage === lastPage }]" @click="onNext">
        <i class="fa fa-angle-right"></i>
      </li>
    </ul>
  </div>
</template>

<script>
import classnames from 'classnames';

export default {
  props: {
    onPageChange: Function,
    totalCount: {
      type: Number,
      required: true
    },
    siblingCount: {
      type: Number,
      default: 1
    },
    currentPage: {
      type: Number,
      required: true
    },
    pageSize: {
      type: Number,
      required: true
    }
  },
  computed: {
    paginationRange() {
      const totalPages = Math.ceil(this.totalCount / this.pageSize);
      return Array.from({ length: totalPages }, (_, index) => index + 1);
    },
    lastPage() {
      return this.paginationRange[this.paginationRange.length - 1];
    },
    visiblePaginationRange() {
      const start = Math.max(1, this.currentPage - 4);
      const end = Math.min(start + 9, this.lastPage);
      return Array.from({ length: end - start + 1 }, (_, index) => index + start);
    },
    paginatedList() {
      // Simulating a list with page numbers for demonstration purposes
      const start = (this.currentPage - 1) * this.pageSize + 1;
      const end = Math.min(start + this.pageSize - 1, this.totalCount);
      return Array.from({ length: end - start + 1 }, (_, index) => index + start);
    }
  },
  methods: {
    selectPage(pageNumber) {
      this.onPageChange(pageNumber);
      this.$emit('page-selected', pageNumber);
    },
    onNext() {
      if (this.currentPage < this.lastPage) {
        this.onPageChange(this.currentPage + 1);
      }
    },
    onPrevious() {
      if (this.currentPage > 1) {
        this.onPageChange(this.currentPage - 1);
      }
    }
  }
};
</script>

<style scoped>
.list {
  padding: 0;
  list-style: none;
}

.google-pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
  padding: 0;
  list-style: none;
}

.google-pagination li {
  margin: 0 5px;
}

.google-pagination .pagination-item {
  display: inline-block;
  cursor: pointer;
  padding: 5px 10px;
  border: none;
  background: none;
  color: #333;
}

.google-pagination .pagination-item.active {
  color: #fff;
  border-radius: 8px;
  background-color: #0d6efd;
}

.google-pagination .pagination-item.disabled {
  cursor: not-allowed;
  opacity: 0.6;
}

.google-pagination i {
  color: blue;
  font-size: 24px;
}

.google-pagination span {
  margin: 0 5px;
}

</style>

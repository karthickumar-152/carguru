<template>
  <div class="p-6 space-y-8 text-sm">
    <h1 class="text-2xl font-bold mb-4">CAR MASTER DATA / BIDDING</h1>

    <!-- BID INCREMENT -->
    <section class="border p-5 rounded-xl shadow">
      <h2 class="font-semibold text-lg mb-4">BID INCREMENT</h2>
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="p-2">From</th>
            <th class="p-2">To</th>
            <th class="p-2">Increment</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(r,i) in form.bidIncrement" :key="i">
            <td><input v-model="r.from" class="input" /></td>
            <td><input v-model="r.to" class="input" /></td>
            <td><input v-model="r.amount" class="input" /></td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- TIMING -->
    <section class="border p-5 rounded-xl shadow">
      <h2 class="font-semibold text-lg mb-4">TIMING</h2>
      <div class="grid grid-cols-4 md:grid-cols-3 gap-5">
        <div>
          <label>Bid Session Duration (minutes)</label>
          <input v-model="form.timing.sessionDuration" class="input" />
        </div>
        <div>
          <label>Timing After Each Bid</label>
          <input v-model="form.timing.afterEachBid" class="input" />
        </div>
        <div>
          <label>First Interval</label>
          <input v-model="form.timing.firstInterval" class="input" />
        </div>
        <div>
          <label>Second Interval</label>
          <input v-model="form.timing.secondInterval" class="input" />
        </div>
        <div>
          <label>Third Interval</label>
          <input v-model="form.timing.thirdInterval" class="input" />
        </div>
        <div>
          <label>Countdown Activation</label>
          <input v-model="form.timing.countdownActivation" class="input" />
        </div>
      </div>
    </section>

<!-- PREVIEW / COOLING -->
<section class="border p-5 rounded-xl shadow">
  <h2 class="font-semibold text-lg mb-4">PREVIEW & COOLING PERIOD</h2>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label>Preview Before Bid (hours)</label>
      <select v-model="form.previewBeforeBid" class="input">
        <option value="" disabled>Select duration</option>
        <option value="12">12 Hours</option>
        <option value="24">24 Hours</option>
      </select>
    </div>
    <div>
      <label>Cooling Period For Bid (hours)</label>
      <select v-model="form.coolingPeriod" class="input">
        <option value="" disabled>Select duration</option>
        <option value="12">12 Hours</option>
        <option value="24">24 Hours</option>
      </select>
    </div>
  </div>
</section>

    <!-- REBID SCHEDULING -->
    <section class="border p-5 rounded-xl shadow">
      <h2 class="font-semibold text-lg mb-4">REBID SCHEDULING</h2>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label>After Number of Bid Sessions</label>
          <input v-model="form.rebid.afterSessions" class="input" />
        </div>
        <div>
          <label>Rebid Attempts Allowed</label>
          <input v-model="form.rebid.attempts" class="input" />
        </div>
      </div>
    </section>

    <!-- REBID VALUE -->
<section class="border p-5 rounded-xl shadow">
  <h2 class="font-semibold text-lg mb-4">REBID VALUE</h2>
  <div class="grid grid-cols-2 gap-4">
    <div>
      <label>Reserved Price Reduction (%)</label>
      <input
        v-model="form.rebidValue.reduction"
        type="text"
        class="input"
        @input="validateReduction"
        placeholder="Enter %"
      />
    </div>
    <div>
      <label>Time Extension (seconds)</label>
      <input
        v-model="form.rebidValue.extension"
        type="text"
        class="input"
        @input="form.rebidValue.extension = form.rebidValue.extension.replace(/[^0-9]/g, '')"
        placeholder="Enter seconds"
      />
    </div>
  </div>
</section>


    <!-- BID SCHEDULE -->
<section class="border p-5 rounded-xl shadow">
  <h2 class="font-semibold text-lg mb-4">BID SCHEDULE</h2>
  <div v-for="(s, i) in form.bidSchedule" :key="i" class="grid grid-cols-5 gap-2 mb-2">
    <select v-model="s.fromDay" class="input">
      <option value="" disabled>From Day</option>
      <option v-for="day in days" :key="day" :value="day">{{ day }}</option>
    </select>

    <select v-model="s.toDay" class="input">
      <option value="" disabled>To Day</option>
      <option v-for="day in days" :key="day" :value="day">{{ day }}</option>
    </select>

    <input v-model="s.start1" class="input" placeholder="Start 1" />
    <input v-model="s.start2" class="input" placeholder="Start 2" />
    <input v-model="s.start3" class="input" placeholder="Start 3" />
  </div>
</section>


    <!-- BID STATUS STATEMENT -->
    <section class="border p-5 rounded-xl shadow">
      <h2 class="font-semibold text-lg mb-4">BID STATUS STATEMENT</h2>
      <div v-for="(b, i) in form.bidStatus" :key="i" class="grid grid-cols-2 gap-2 mb-2">
        <input v-model="b.status" class="input" placeholder="Status" />
        <input v-model="b.statement" class="input" placeholder="Statement" />
      </div>
    </section>

    <!-- CAR DEPOSIT -->
    <section class="border p-5 rounded-xl shadow">
      <h2 class="font-semibold text-lg mb-4">CAR DEPOSIT</h2>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label>Deposit Upfront Required (%)</label>
          <input v-model="form.carDeposit.percent" class="input" />
        </div>
        <div>
          <label>Only when receipt is attached & paid</label>
          <input v-model="form.carDeposit.condition" class="input" />
        </div>
      </div>
    </section>

    <!-- SAVE -->
    <div class="flex justify-end">
      <button @click="saveForm" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow">
        Save
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "BiddingSettings",
  data() {
  return {
    days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
    form: {
      bidIncrement: [
        { from: "RM 1", to: "RM 9,999", amount: "RM 200" },
        { from: "RM 10,000", to: "RM 49,999", amount: "RM 500" },
        { from: "RM 50,000", to: "RM 99,999", amount: "RM 1000" },
      ],
      timing: {
        sessionDuration: 60,
        afterEachBid: 60,
        firstInterval: 60,
        secondInterval: 30,
        thirdInterval: 10,
        countdownActivation: "3 minutes",
      },
      previewBeforeBid: 24,
      coolingPeriod: 12,
      rebid: { afterSessions: 2, attempts: 3 },
      rebidValue: { reduction: 10, extension: 60 },
      bidSchedule: [
        { fromDay: "Monday", toDay: "Friday", start1: "10:00 AM", start2: "8:00 PM", start3: "" },
        { fromDay: "Saturday", toDay: "Saturday", start1: "10:00 AM", start2: "2:00 PM", start3: "8:00 PM" },
      ],
      bidStatus: [
        { status: "Upcoming Bid", statement: "Notify Me" },
        { status: "Bid In Session", statement: "Go Bid!" },
        { status: "Bid Completed", statement: "Bid Ended" },
        { status: "Win Bid", statement: "Congratulations!" },
        { status: "Lose Bid", statement: "You Lost The Bid." },
      ],
      carDeposit: {
        percent: 30,
        condition: "Only when receipt is attached & PAID status for booking Fee can proceed to loan page",
      },
    },
  };
},

  methods: {
    saveForm() {
      console.log(JSON.stringify(this.form, null, 2));
      alert("✅ Data printed in console as JSON");
    },
  },
  methods: {
  saveForm() {
    // Validate Reserved Price Reduction (only when saving)
    let reduction = parseInt(this.form.rebidValue.reduction || 0);
    if (isNaN(reduction) || reduction <= 0) reduction = 1;
    if (reduction > 100) reduction = 100;
    this.form.rebidValue.reduction = reduction.toString();

    console.log(JSON.stringify(this.form, null, 2));
    alert("✅ Data printed in console as JSON");
  },
}
};
</script>

<style scoped>
.input {
  @apply w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400;
}
</style>

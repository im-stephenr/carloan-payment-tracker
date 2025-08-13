<script setup>
import { computed, onMounted, ref } from "vue";
import DashboardSideInfo from "../Components/DashboardSideInfo.vue";
import MainContainer from "../Components/MainContainer.vue";
import PaymentsListTable from "../Components/PaymentsListTable.vue";
import AuthLayout from "../Layouts/AuthLayout.vue";

const props = defineProps({
    carLoanDetails: Object,
    paymentsList: Array,
    totalBalance: Number,
    totalMonths: Number,
    otherSettings: Object,
});

const totalAmountPaid = computed(() => {
    return (props?.paymentsList || []).reduce((sum, item) => {
        const cleanValue = String(item.amount_paid).replace(/,/g, "");
        const paid = parseFloat(cleanValue);
        return sum + (isNaN(paid) ? 0 : paid);
    }, 0);
});

const totalRemainingMonths = computed(() => {
    return props.totalMonths - props?.paymentsList.length;
});
</script>
<template>
    <AuthLayout>
        <Head title="Dashboard" />
        <DashboardSideInfo
            v-if="
                otherSettings?.hide_total_dp_flag == 0 ||
                otherSettings?.hide_total_paid_flag == 0 ||
                otherSettings?.hide_total_balance_flag == 0 ||
                otherSettings?.hide_remaining_months_flag == 0
            "
            :otherSettings="otherSettings"
            :carLoanDetails="carLoanDetails"
            :totalAmountPaid="totalAmountPaid"
            :totalBalance="totalBalance"
            :totalRemainingMonths="totalRemainingMonths"
        />
        <!--Graph Content -->
        <MainContainer pageTitle="Payment History">
            <PaymentsListTable
                :paymentsList="paymentsList"
                :actionColumn="false"
            />
            <!--/table Card-->
        </MainContainer>
    </AuthLayout>
</template>

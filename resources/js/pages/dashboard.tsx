import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
const boxes = new Array(20).fill(0); // Example with 20 components

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz overview" />
            <div className="m-7 grid grid-cols-4 gap-4">
                {boxes.map((_, idx) => (
                    <div
                        key={idx}
                        className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] overflow-hidden rounded-xl border"
                    >
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                ))}
            </div>
        </AppLayout>
    );
}

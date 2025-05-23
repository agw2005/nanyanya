import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { Toggle } from '@/components/ui/toggle';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz created',
        href: '/quiz-created',
    },
];
const boxes = new Array(20).fill(0); // Example with 20 components

export default function Index() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz Taken" />

            <div className="flex h-[calc(100vh-100px)] flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Info section – only takes needed height */}
                <div className="shrink-0">
                    <p>Quiz name : PyTorch Exam</p>
                    <p>Number of questions : 10</p>
                    <p>Participants : 41</p>
                </div>

                {/* Scrollable box grid – takes remaining height */}
                <div className="flex-1 overflow-auto">
                    <div className="grid grid-cols-4 gap-4">
                        {boxes.map((_, idx) => (
                            <div
                                key={idx}
                                className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] overflow-hidden rounded-xl border"
                            >
                                <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

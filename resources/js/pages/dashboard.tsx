import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { useState } from 'react';

const boxes = new Array(20).fill(0);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    const [selectedBox, setSelectedBox] = useState<number | null>(null);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz overview" />
            <div className="m-7 grid grid-cols-4 gap-4">
                {boxes.map((_, idx) => (
                    <div
                        key={idx}
                        onClick={() => setSelectedBox(idx)}
                        className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border"
                    >
                        {/* <img
                            src={`https://via.placeholder.com/400x200?text=Quiz+${idx + 1}`}
                            alt={`Quiz ${idx + 1}`}
                            className="absolute inset-0 size-full object-cover"
                        /> */}
                        <img src={'placeholder-image.jpg'} alt={`Quiz ${idx + 1}`} className="absolute inset-0 size-full object-cover" />
                    </div>
                ))}
            </div>

            {selectedBox !== null && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50" onClick={() => setSelectedBox(null)}>
                    <div
                        className="w-[80%] max-w-4xl rounded-xl bg-white p-6 shadow-lg dark:bg-gray-900"
                        onClick={(e) => e.stopPropagation()} // Prevent modal close on click inside
                    >
                        <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] overflow-hidden rounded-xl border">
                            <img src={'placeholder-image.jpg'} className="absolute inset-0 size-full object-cover" />
                        </div>
                        <div className="mt-6 grid grid-cols-4 gap-4">
                            <button className="rounded bg-blue-500 py-2 text-white">[Quiz Maker]</button>
                            <button className="rounded bg-green-500 py-2 text-white">Participate</button>
                            <button className="rounded bg-yellow-500 py-2 text-white">Like</button>
                            <button className="rounded bg-red-500 py-2 text-white">Likes : 52k</button>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}

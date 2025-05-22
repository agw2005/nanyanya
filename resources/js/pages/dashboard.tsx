import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type Quiz = {
    id: number;
    name: string;
    thumbnail_url: string | null;
};

type Props = {
    quizzes: Quiz[];
};

export default function Dashboard() {
    const { props } = usePage<Props>();
    const quizzes: Quiz[] = props.quizzes || [];
    const [selectedQuizId, setSelectedQuizId] = useState<number | null>(null);
    const selectedQuiz = quizzes.find((q) => q.id === selectedQuizId) || null;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz overview" />
            <div className="m-7 grid grid-cols-4 gap-4">
                {quizzes.map((quiz) => (
                    <div
                        key={quiz.id}
                        onClick={() => setSelectedQuizId(quiz.id)}
                        className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border"
                        title={quiz.name}
                    >
                        <img
                            src={quiz.thumbnail_url ?? 'placeholder-image.jpg'}
                            alt={quiz.name}
                            className="absolute inset-0 size-full object-cover"
                        />
                    </div>
                ))}
            </div>

            {selectedQuiz !== null && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50" onClick={() => setSelectedQuizId(null)}>
                    <div
                        className="w-[80%] max-w-4xl rounded-xl bg-white p-6 shadow-lg dark:bg-gray-900"
                        onClick={(e) => e.stopPropagation()} // Prevent modal close on click inside
                    >
                        <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-[2/1] overflow-hidden rounded-xl border">
                            <img
                                src={selectedQuiz.thumbnail_url ?? 'placeholder-image.jpg'}
                                alt={selectedQuiz.name}
                                className="absolute inset-0 size-full object-cover"
                            />
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

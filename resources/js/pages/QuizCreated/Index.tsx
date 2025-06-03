import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Quiz created',
        href: '/quiz-created',
    },
];

type User = {
    id: number;
    name: string;
    email: string;
};

type Question = {
    id: number;
    question_text: string;
    options: {
        id: number;
        label: string; // e.g. "A", "B"
        option_text: string;
        is_correct: number; // 1 or 0
    }[];
};

type Answer = {
    question_id: number;
    selected_option: string; // e.g. "A", "B"
};

type ParticipantAnswer = {
    user: {
        id: number;
        name: string;
    };
    answers: Answer[];
};

type Quiz = {
    id: number;
    name: string;
    thumbnail_url: string | null;
    user: User;
    questions: Question[];
    participants_count?: number;
    participant_answers?: ParticipantAnswer[]; // Add this
};

type Props = {
    quizzes: Quiz[];
};

export default function Index() {
    const { props } = usePage<Props>();
    const quizzes: Quiz[] = props.quizzes || [];
    const [selectedQuizId, setSelectedQuizId] = useState<number | null>(null);
    const selectedQuiz = quizzes.find((q) => q.id === selectedQuizId) || null;
    const [showModal, setShowModal] = useState(false);
    const [participantIndex, setParticipantIndex] = useState(0);
    const participantAnswers = selectedQuiz?.participant_answers ?? [];
    const currentParticipant = participantAnswers[participantIndex];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Quiz Taken" />

            <div className="flex h-[calc(100vh-100px)] flex-1 flex-col gap-4 rounded-xl p-4">
                {/* Info section – only takes needed height */}
                <div className="shrink-0">
                    <p>Quiz name : {selectedQuiz?.user?.name}</p>
                    <p>Number of questions : {selectedQuiz?.questions?.length ?? 0}</p>
                    <p>Participants : {selectedQuiz?.participants_count ?? 0}</p>
                    <button
                        disabled={selectedQuizId === null || (selectedQuiz?.participants_count ?? 0) === 0}
                        onClick={() => {
                            setShowModal(true);
                            setParticipantIndex(0);
                        }}
                        className={`mt-2 rounded bg-red-900 p-2 text-white ${
                            selectedQuizId !== null && (selectedQuiz?.participants_count ?? 0) > 0
                                ? 'cursor-pointer'
                                : 'cursor-not-allowed opacity-50'
                        }`}
                    >
                        See submissions
                    </button>
                </div>

                {/* Scrollable box grid – takes remaining height */}
                <div className="flex-1 overflow-auto">
                    <div className="grid grid-cols-4 gap-4">
                        {quizzes.map((quiz) => {
                            const isSelected = quiz.id === selectedQuizId;

                            return (
                                <div
                                    key={quiz.id}
                                    onClick={() => {
                                        if (selectedQuizId != quiz.id) {
                                            setSelectedQuizId(quiz.id);
                                        } else {
                                            setSelectedQuizId(null);
                                        }
                                    }}
                                    className={`relative aspect-[2/1] cursor-pointer overflow-hidden rounded-xl border ${
                                        isSelected ? 'border-4 border-red-600' : 'border-sidebar-border/70 dark:border-sidebar-border'
                                    }`}
                                    title={quiz.name}
                                >
                                    {/* Image */}
                                    <img
                                        src={quiz.thumbnail_url ?? 'placeholder-image.jpg'}
                                        alt={quiz.name}
                                        className={`absolute inset-0 h-full w-full object-cover transition duration-300 ${isSelected ? 'brightness-50' : 'brightness-100'}`}
                                    />

                                    {/* Selected Overlay */}
                                    {isSelected && (
                                        <div className="absolute inset-0 flex items-center justify-center">
                                            <span className="text-lg font-bold text-white select-none">Selected</span>
                                        </div>
                                    )}
                                </div>
                            );
                        })}
                    </div>
                </div>
                {/* Modal */}
                {showModal && selectedQuiz && currentParticipant && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60" onClick={() => setShowModal(false)}>
                        <div
                            className="relative max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-xl bg-white p-8 dark:bg-gray-900"
                            onClick={(e) => e.stopPropagation()}
                        >
                            <h2 className="mb-4 text-xl font-bold">Answers by {currentParticipant.user.name}</h2>

                            {/* Close button */}
                            <button
                                className="mt-6 w-full rounded bg-red-500 py-2 font-bold text-white hover:bg-red-600"
                                onClick={() => setShowModal(false)}
                            >
                                Close
                            </button>

                            {/* Navigation Arrows */}
                            <div className="my-6 flex items-center justify-between gap-2">
                                <button
                                    disabled={participantIndex === 0}
                                    onClick={() => setParticipantIndex((i) => i - 1)}
                                    className="rounded bg-gray-300 px-4 py-2 disabled:opacity-50 dark:bg-gray-700"
                                >
                                    ← Previous
                                </button>
                                <button
                                    disabled={participantIndex === participantAnswers.length - 1}
                                    onClick={() => setParticipantIndex((i) => i + 1)}
                                    className="rounded bg-gray-300 px-4 py-2 disabled:opacity-50 dark:bg-gray-700"
                                >
                                    Next →
                                </button>
                            </div>
                            <div className="space-y-6">
                                {selectedQuiz.questions.map((question, qIdx) => {
                                    const answer = currentParticipant.answers.find((a) => a.question_id === question.id);
                                    return (
                                        <div key={question.id}>
                                            <div className="font-semibold">
                                                {qIdx + 1}. {question.question_text}
                                            </div>
                                            <div className="mt-2 grid grid-cols-1 gap-2">
                                                {question.options.map((opt) => {
                                                    const isCorrect = opt.is_correct === 1;
                                                    const isUser = answer?.selected_option === opt.label;

                                                    return (
                                                        <div
                                                            key={opt.id}
                                                            className={`flex items-center rounded border px-4 py-2 transition-all ${
                                                                isCorrect
                                                                    ? 'border-green-700 bg-green-100 dark:bg-green-900'
                                                                    : 'border-gray-500 dark:bg-[#262626]'
                                                            } ${isUser ? (isCorrect ? 'ring-2 ring-green-500' : 'ring-2 ring-blue-400') : ''}`}
                                                        >
                                                            {opt.option_text}
                                                            {isCorrect && (
                                                                <span className="ml-2 font-bold text-green-700 dark:text-green-300">(Correct)</span>
                                                            )}
                                                            {isUser && !isCorrect && (
                                                                <span className="ml-2 font-bold text-blue-600 dark:text-blue-300">
                                                                    (Their choice)
                                                                </span>
                                                            )}
                                                        </div>
                                                    );
                                                })}
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
